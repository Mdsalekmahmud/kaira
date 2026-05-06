<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(Order $order)
    {
    
        return view('pages.stripe', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
        $charge = $stripe->charges->create([
            'amount'   => $request->price * 100, // Convert to cents
            'currency' => 'usd',
            'source'   => $request->stripeToken,
            'description' => 'Payment for Order in kaira.com' . $request->order_id,
        ]);
         
        return redirect()->route('index')->with('success', 'Payment successful!');
    }
}
