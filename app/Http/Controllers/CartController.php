<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Products::findOrFail($productId);
        $quantity = $request->input('qty', 1); // Set the default value to 1 if 'qty' is not provided
    
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();
    
        if ($cartItem === null) {
            $cartItem = new Cart([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        } else {
            $cartItem->quantity += $quantity;
        }
    
        $cartItem->save();
    
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    
    


    public function showCart()
    {
        $user = Auth::user();
        if($user){
            $cartItems = Cart::where('user_id', $user->id)->get()->load('product');
    
            // Calculate subTotal
            if($cartItems){
                $subTotal = $cartItems->sum(function($item) {
                    return $item->quantity * $item->product->price;
                });
            }
            
            return view('cart', [
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
            ]);
        }
    }
    
    

    public function updateQuantity(Request $request)
    {
        Log::info('Request data:', $request->all());

        $cartItemId = $request->input('cartItemId');
        $quantity = $request->input('quantity');

        $cartItem = Cart::find($cartItemId);

        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
            return response()->json(['success' => true, 'message' => 'Cart item quantity updated.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found.']);
        }
    }


    public function removeItem($id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully',
        ]);
    }


}
