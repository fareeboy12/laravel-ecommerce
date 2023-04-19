<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\CartRepository;


class OrderController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'required',
            'country' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'notes' => 'required',
            'payment_method' => 'required',
        ]);

        $orderNumber = strtoupper(Str::random(10));

        $order = new Order($validatedData);
        $order->user_id = auth()->id();
        $order->order_number = $orderNumber;
        // Add cart and payment information to the order
        $cart = $this->cartRepository->showCart(auth()->id());
        $order->subtotal = $cart['subTotal'];
        $order->shipping_fee = $cart['shippingFee'];
        $order->coupon_price = $cart['couponPrice'];
        $order->total = $cart['totalPrice'];
        $order->payment_status = $request->payment_method === 'credit_card' ? 'pending' : 'to be paid on delivery';
        $order->save();

        // Insert order items data
        foreach ($cart['cartItems'] as $item) {
            $orderItem = new OrderItem([
                'order_id' => $order->id, // Add the order_id here
                'product_id' => $item->product->id,
                'quantity' => $item->quantity
            ]);
            $order->orderItems()->save($orderItem);
        }

        if ($request->payment_method === 'credit_card') {
            // Redirect to the payment page
            return redirect()->route('payment.show', $order->id);
        }
        return redirect()->route('order.thankyou', $order->id);
    }

    public function thankyou($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('thankyou', compact('order'));
    }

    public function showPayment($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('payment', compact('order'));
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


}
