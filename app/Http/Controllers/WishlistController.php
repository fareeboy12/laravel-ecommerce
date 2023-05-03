<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $wishlists = $user->wishlists()->with('product')->get();
        return view('wishlists', compact('wishlists'));
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $user = Auth::user();
        $product_id = $request->input('product_id');

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $product_id
        ]);

        return response()->json(['message' => 'Product added to wishlist']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function destroy($id)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('id', $id)->first();

        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Product removed from wishlist']);
    }
}
