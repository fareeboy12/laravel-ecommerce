<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function create()
    {
        // return view('layouts.coupons');
        $coupons = Coupon::all();
        return view('layouts.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'coupon_code' => 'required|unique:coupons',
            'coupon_price' => 'required|numeric',
        ]);

        Coupon::create($validatedData);

        return redirect()->back()->with('success', 'Coupon added successfully');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $id,
            'coupon_price' => 'required|numeric',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update($validatedData);

        return response()->json(['success' => 'Coupon updated successfully']);
    }

    public function index()
{
    $coupons = Coupon::all();
    return response()->json($coupons);
}

}
