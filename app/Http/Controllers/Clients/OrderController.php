<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->order->getWithPaginateBy(auth()->user()->id);
        return view('clients.orders.orders', compact('orders'));
    }
    public function cancel($id) {
        $order = $this->order->findOrFail($id);
        $order->update(['status'=> 'canceled']);
        return redirect()->route('orders')->with(['message'=>'Order canceled']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
