<?php

namespace App\Http\View\Composers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
       if($user){
            $cartItems = Cart::where('user_id', $user->id)->get()->load('product');
        
            // Calculate subTotal
            $subTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
        
            $view->with([
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
            ]);
       }
    }
}
