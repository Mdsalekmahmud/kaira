<?php
namespace App\Http\Controllers;

use App\Models\DeliveryCrg;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use TaxService;
use Cart;
use ServiceTax;

class PageController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.home', compact('products'));
    }

    public function shop()
    {
        $products = Product::all();
        return view('pages.shop',compact('products'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }
    public function blog()
    {
        return view('pages.blog');
    }

    public function contact()
    {
        return view('pages.contact');
    }
    
    public function cart()
    {
        $total = TaxService::totalAmount(100);
        return view('pages.cart',compact('total'));
    }
    public function checkout()
    {
        $deliveryCrgs=DeliveryCrg::all();
        $total = TaxService::totalAmount(100);
        return view('pages.checkout',compact('total','deliveryCrgs'));
    
    }

   
    
    public function dashboard()
    {
        return view('dashboard_page.index');
    }

    

    public function profile()
    {
        $orders=order::with('products')->where('user_id', auth()->user()->id)->get();
        return view('pages.profile',compact('orders'));
    }

}
