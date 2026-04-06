<?php
namespace App\Http\Controllers;

use App\Models\DeliveryCrg;
use Illuminate\Http\Request;

class DeliveryCrgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryCrgs=DeliveryCrg::all();
        return view('dashboard_page.deliveryCrg.index',compact('deliveryCrgs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard_page.deliveryCrg.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DeliveryCrg::create([
            'location' => $request->location,
            'delivery_charge' => $request->delivery_charge,
        ]);
        return redirect()->route('deliveryCrg.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryCrg $deliveryCrg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryCrg $deliveryCrg)
    {
        return view('dashboard_page.deliveryCrg.edit',compact('deliveryCrg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryCrg $deliveryCrg)
    {
        $deliveryCrg->update([
            'location' => $request->location,
            'delivery_charge' => $request->delivery_charge,
        ]);
          return redirect()->route('deliveryCrg.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryCrg $deliveryCrg)
    {
        $deliveryCrg->delete();
        return redirect()->route('deliveryCrg.index');
    }
}
