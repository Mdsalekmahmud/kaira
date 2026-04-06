<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(Order $order)
    {
        return view('pages.stripe', compact('order'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    } 
}
