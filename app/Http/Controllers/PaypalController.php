<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function index(Order $order)
    {
        return view('pages.paypal', compact('order'));
    }
}
