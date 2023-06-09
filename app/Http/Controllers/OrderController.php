<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\CartRepository;
use App\Http\Controllers\PaymentController;
use Stripe\Stripe;
use App\Mail\OrderConfirmation;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;




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
        $order->order_status = "processing";
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

        Mail::to($order->email)->send(new OrderConfirmation($order));


        $guzzleClient = new GuzzleHttpClient();

        $response = $guzzleClient->post('https://graph.facebook.com/v16.0/104907332408432/messages', [
            'headers' => [
                'Authorization' => 'Bearer EAAKzV83BxhIBAO4CQcdU4q1CzwdPM1UCOUCOiUZAhmZCvJUOaCFzDWpYyhh8KuoAkjYbl8ZALHRLacIu88oQ2ZAr5TFJ04olkUbSZBwZCe8U06AEckTKcR0LipZCz1Pqt7hCnkpEdpcoM5nEz3CsTZBshqBfCkH0ioRrH6bnZBTAhZCahpXvzXNQyQZBuKKFDrlWYr2Oo9L8H8yPL2MPp7vwPJ0QwK3beBMt9UZD',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => $order->phone,
                'type' => 'template',
                'template' => [
                    'name' => 'laravel_ecommerce',
                    'language' => [
                        'code' => 'en_US',
                    ],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $order->first_name,
                                ],
                                [
                                    'type' => 'text',
                                    'text' => $order->last_name,
                                ],
                                [
                                    'type' => 'text',
                                    'text' => $order->order_number,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);

        // Send SMS notification
        $twilioAccountSid = Config::get('app.TWILIO_ACCOUNT_SID');
        $twilioAuthToken = Config::get('app.TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = '+12545565156';

        $twilioClient = new TwilioClient($twilioAccountSid, $twilioAuthToken);
        $twilioClient->messages->create(
            $order->phone, // recipient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => 'Your Order number #' . $order->order_number . ' has been confirmed. Thank you!',
            ]
        );

        // Delete cart data for the user
        $this->cartRepository->deleteCart(auth()->id());
        
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

    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('layouts.all-orders', compact('orders'));
    }
    

    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('layouts.order-details', compact('order'));
    }

    public function updateOrderStatus(Order $order, Request $request)
    {
        $order_status = $request->input('order_status');
    
        if ($order_status === null || $order_status === '') {
            return response()->json(['error' => 'Order status cannot be null or empty'], 400);
        }
    
        $order->order_status = $order_status;
        $order->save();
    
        return response()->json(['message' => 'Order status updated successfully.']);
    }
}