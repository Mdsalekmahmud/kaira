<?php
namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Models\DeliveryCrg;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use TaxService;

class CardController extends Controller
{

    public function cartadd(Request $request)
    {

        $product = Product::findOrFail($request->product_add);
        // $name = $product->name;
        // $price = $product->s_price ?? $product->price;
        // $qty = 1;
        Cart::add(
            [
                'id'     => $product->id,
                'name'   => $product->name,
                'price'  => $product->s_price ?? $product->price,
                'qty'    => 1,
                'weight' => 0,
            ]
        );

        // $cartitems=Cart::content();

        return back();
    }

    public function cartupdate(Request $request, $rowId)
    {
        $qty = $request->input('qty');
        // Using Cart package example (like Gloudemans\Shoppingcart)
        \Cart::update($rowId, ['qty' => $qty]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function cartdestroy(Request $request, $rowId)
    {
        Cart::remove($rowId);

        return back();
    }

    public function checkout(Request $request)
    {
        $delivery     = DeliveryCrg::where('id', $request->state_country)->first();
        $delivery_crg = $delivery ? (float) $delivery->delivery_charge : 0;
        $subTotal     = str_replace(',', '', Cart::subtotal());
        $totalAmount  = str_replace(',', '', TaxService::totalAmount());
        $tax          = str_replace(',', '', TaxService::calculate());

        $order = Order::create([
            'user_id'        => auth()->check() ? auth()->id() : null,
            'sub_total'      => $subTotal,
            'total_amount'   => $totalAmount + $delivery_crg,
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

        Mail::to($shippingInfo['email_address'])
            ->send(new OrderShipped($order));

        Cart::destroy();

        return redirect()->route('stripe', $order->id);

    }

}
