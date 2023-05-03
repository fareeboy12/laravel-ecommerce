<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $cart = $this->cartRepository->showCart($user->id);

            if (!$cart) {
                return redirect('/cart');
            }

            return view('checkout', compact('cart'));
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'street_address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'payment_method' => 'required',
        ]);

        $cart = Cart::getCart();

        if (!$cart) {
            return redirect('/cart');
        }

        $order = Order::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'company_name' => $request->input('company_name'),
            'country' => $validatedData['country'],
            'street_address1' => $validatedData['street_address1'],
            'street_address2' => $request->input('street_address2'),
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'postcode' => $validatedData['postcode'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'notes' => $request->input('notes'),
            'payment_method' => $validatedData['payment_method'],
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $user = Auth::user();
        if ($user->user_type == "guest") {
            Cart::where('user_id', $user->id)->delete();
            $user->delete();
        }
        
        Cart::clearCart();

        return redirect('/thank-you')->with('success', 'Your order has been placed successfully!');
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('coupon_code', $couponCode)->first();
    
        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid coupon code');
        }
    
        // Get the current user's ID (assuming you're using the default authentication)
        $userId = auth()->id();
    
        // Get the current user's cart
        $cartDetails = $this->cartRepository->showCart($userId);
    
        if (!$cartDetails['cartItems']->count()) {
            return redirect()->back()->with('error', 'Cart not found');
        }
    
        $cartItems = $cartDetails['cartItems'];
    
        // Apply the coupon to all items in the cart
        foreach ($cartItems as $cartItem) {
            $cartItem->update([
                'coupon_code' => $coupon->coupon_code,
                'coupon_price' => $coupon->coupon_price,
            ]);
        }
    
        return redirect()->back()->with('success', 'Coupon applied successfully');
    }
    
}
