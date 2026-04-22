<?php
namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Mail\UserPasswordMail;
use App\Models\Coupon;
use App\Models\DeliveryCrg;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use TaxService;

class CartController extends Controller
{

    public function cartadd(Request $request)
    {

        $product = Product::findOrFail($request->product_add);

        Cart::add(
            [
                'id'     => $product->id,
                'name'   => $product->name,
                'price'  => $product->s_price ?? $product->price,
                'qty'    => 1,
                'weight' => 0,
            ]
        );

        return back();
    }

    public function cartupdate(Request $request, $rowId)
    {
        $qty = $request->input('qty');

        Cart::update($rowId, ['qty' => $qty]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function cartdestroy(Request $request, $rowId)
    {

        Cart::remove($rowId);
        if (Cart::count() == 0) {
            session()->forget('coupon');
        }
        return back();
    }

    public function checkout(Request $request)
    {
        $delivery     = DeliveryCrg::where('id', $request->state_country)->first();
        $delivery_crg = $delivery ? (float) $delivery->delivery_charge : 0;

        $subTotal   = (float) str_replace(',', '', Cart::subtotal());
        $tax        = (float) TaxService::calculate();
        $discount   = session('coupon.discount') ?? 0;
        $couponCode = null;

        // if (session()->has('coupon')) {
        //     $discount = session('coupon.discount');
        // }
        $finalTotal = $subTotal + $tax + $delivery_crg - $discount;

        $userId     = null;

        if (auth()->check()) {

            $userId = auth()->id();

        } else {

            $password = Str::random(8);

            $user = User::create([
                'role_id'         => 3,
                'fast_name'       => $request['fname'],
                'last_name'       => $request['lname'],
                'country'         => $request['country'],
                'c_companyname'   => $request['companyname'],
                'c_address'       => $request['address'],
                'c_postal_zip'    => $request['postal_zip'],
                'c_state_country' => $request['c_state_country'] ?? $request['state_country'],
                'c_phone'         => $request['phone'],
                'email'           => $request['email_address'],
                'password'        => Hash::make($password),
            ]);

            $userId = $user->id;

            Mail::to($user->email)
                ->later(now()->addSeconds(5), new UserPasswordMail($user, $password));
        }
        $order = Order::create([
            'user_id'        => $userId,
            'sub_total'      => $subTotal,
            'discount'       => $discount,
            'coupon_code'    => $couponCode,
            'total_amount'   => $finalTotal,
            'tax'            => $tax,
            'delivery_crg'   => $delivery_crg,
            'shipping_info'  => json_encode([
                'c_country'     => $request->c_country,
                'fname'         => $request->fname,
                'lname'         => $request->lname,
                'companyname'   => $request->companyname,
                'address'       => $request->address,
                'apartment'     => $request->Apartment,
                'state_country' => $request->state_country,
                'postal_zip'    => $request->postal_zip,
                'email_address' => $request->email_address,
                'phone'         => $request->phone,
            ]),
            'payment_status' => 'unpaid',
            'status'         => 'pending',
        ]);

        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id'   => $order->id,
                'product_id' => $item->id,
                'quantity'   => $item->qty,
                'price'      => $item->price,
                'total'      => $item->qty * $item->price,
            ]);
        }

        $shippingInfo = json_decode($order->shipping_info, true);

        Mail::to($shippingInfo['email_address'])->send(new OrderShipped($order));

        session()->forget('coupon');
        session()->regenerate();
        Cart::destroy();
        return redirect()->route('stripe', $order->id);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
        ]);

        $subTotal = (float) str_replace(',', '', Cart::subtotal());

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->where('status', 1)
            ->first();

        if (! $coupon) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid coupon',
            ]);
        }

        // expired check
        if ($coupon->expired_at && Carbon::now()->gt(Carbon::parse($coupon->expired_at))) {
            return response()->json([
                'status'  => false,
                'message' => 'Coupon expired',
            ]);
        }

        // min amount check
        if ($coupon->min_amount && $subTotal < $coupon->min_amount) {
            return response()->json([
                'status'  => false,
                'message' => 'Minimum amount is ' . $coupon->min_amount,
            ]);
        }

        // discount calculate
        if ($coupon->type == 'fixed') {
            $discount = $coupon->value;
        } else {
            $discount = ($subTotal * $coupon->value) / 100;
        }

        if ($discount > $subTotal) {
            $discount = $subTotal;
        }
        session()->forget('coupon');
        // 👉 session save
        session()->put('coupon', [
            'code'     => $coupon->code,
            'discount' => $discount,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status'   => true,
                'message'  => 'Coupon applied successfully',
                'discount' => $discount,
            ]);
        }

        return redirect()->route('checkout');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');

        if (request()->expectsJson()) {
            return response()->json([
                'status'  => true,
                'message' => 'Coupon removed',
            ]);
        }

        return redirect()->route('checkout');
    }
}
