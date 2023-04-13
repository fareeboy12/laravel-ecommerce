<?php
namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    public function showCart($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get()->load('product');

        // Calculate subTotal
        if ($cartItems) {
            $subTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            $shippingFee = $cartItems->first()->shipping_fee ?? 0;
            $couponPrice = $cartItems->first()->coupon_price ?? 0;
            $totalPrice = $subTotal + $shippingFee - $couponPrice;
        } else {
            $subTotal = 0;
            $shippingFee = 0;
            $couponPrice = 0;
            $totalPrice = 0;
        }

        return [
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'shippingFee' => $shippingFee,
            'couponPrice' => $couponPrice,
            'totalPrice' => $totalPrice,
        ];
    }
}
