<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Repositories\CartRepository;


class CartController extends Controller
{

    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function showCart()
    {
        $user = Auth::user();
        if ($user) {
            $cart = $this->cartRepository->showCart($user->id);

            return view('cart', $cart);
        }
    }

    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();

        // Check if the user is not logged in, then create a guest user
        if ($user === null) {
            $guestId = (string) Str::uuid();
            $user = new User();
            $user->email = Str::uuid() . '@example.com'; // Generate a unique email address
            $user->password = bcrypt(Str::random(16)); // Generate a random password
            $user->user_type = "guest";
            $user->first_name = 'Guest';
            $user->last_name = $guestId;
            $user->save();

            Auth::login($user); // Log the guest user in for the current session
        }

        $product = Products::findOrFail($productId);
        $quantity = $request->input('qty', 1);
        $price = $product->price;
        $total = $price * $quantity;

        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($cartItem === null) {
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $product->id;
            $cartItem->price = $price;
            $cartItem->quantity = $quantity;
            $cartItem->total = $total;
        } else {
            $cartItem->quantity += $quantity;
            $cartItem->total = $price * $cartItem->quantity;
        }

        $cartItem->save();

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }    

    public function getCartData()
    {
        $user = Auth::user();
        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)
                            ->with('product')
                            ->get();
            $cartCount = $cartItems->count();
            $cartTotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            $cartData = [
                'count' => $cartCount,
                'total' => $cartTotal,
                'items' => $cartItems
            ];
            return response()->json($cartData);
        }
        return response()->json(['count' => 0, 'total' => 0, 'items' => []]);
    }
    

    
    
    public function updateCart(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user
        $cartItems = Cart::where('user_id', $user->id)->get();
    
        if (!$cartItems) {
            return redirect()->back()->withErrors(['Cart not found.']);
        }
    
        // Update the quantity for each cart item
        foreach ($request->quantities as $id => $quantity) {
            $cartItem = $cartItems->where('id', $id)->first();
            if (!$cartItem) {
                return redirect()->back()->withErrors(['Cart item not found.']);
            }
            if ($cartItem->quantity != $quantity) {
                $cartItem->quantity = $quantity;
                $cartItem->total = $quantity * $cartItem->product->price;
                $cartItem->save();
            }
        }
    
        // Update the shipping cost and total price
        $shippingMethod = $request->shipping;
        $shippingCost = 0;
    
        if ($shippingMethod == 'standard') {
            $shippingCost = 10;
        } elseif ($shippingMethod == 'express') {
            $shippingCost = 20;
        }
    
        $subTotal = $cartItems->sum('total');
        $couponCode = $request->coupon_code;
        $couponPrice = 0;
    
        // Check if the coupon code exists in the cart table
        $cartCoupon = null;
        if ($couponCode) {
            $cartCoupon = Coupon::where('coupon_code', $couponCode)->first();
            if (!$cartCoupon) {
                return redirect()->back()->withErrors(['Invalid coupon code.']);
            }
            $couponPrice = $cartCoupon->coupon_price;
        }
    
        $totalPrice = max($subTotal - $couponPrice + $shippingCost, 0);
    
        $cartUpdateData = [
            'shipping_method' => $shippingMethod,
            'shipping_fee' => $shippingCost,
            'total' => $totalPrice,
        ];
    
        if ($cartCoupon) {
            $cartUpdateData['coupon_code'] = $couponCode;
            $cartUpdateData['coupon_price'] = $couponPrice;
        }
    
        Cart::where('user_id', $user->id)->update($cartUpdateData);
    
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
    
    
    public function removeCartItem($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function showCartDetails()
    {
        $cartItems = Cart::with(['user', 'product'])->get();
        return view('layouts.carts', ['cartItems' => $cartItems]);
    }
    
    


}
