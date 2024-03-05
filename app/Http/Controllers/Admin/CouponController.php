<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\CreateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $coupon;
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = $this->coupon->latest('id')->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCouponRequest $request)
    {
        $dataCreate = $request->all();
        $this->coupon->create($dataCreate);
        return to_route('coupons.index')->with(['message'=> 'create successful']);
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
        $coupon = $this->coupon->findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataUpdate = $request->all();
        $coupon = $this->coupon->findOrFail($id);
        $coupon->update($dataUpdate);
        return to_route('coupons.index')->with(['message'=> 'update successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = $this->coupon->findOrFail($id);
        $coupon->delete();
        return to_route('coupons.index')->with(['message'=> 'delete '.$coupon->name.' successful']);
    }
}
