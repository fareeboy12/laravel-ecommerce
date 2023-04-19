<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        return view('payment', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        // Set your Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the stripeToken from the submitted form
        $stripeToken = $request->input('stripeToken');

        // Calculate the total amount in cents (replace with the total amount of products in the cart)
        $totalAmountInCents = $order->total * 100; // Example: $10.00 = 1000 cents

        // Create a charge using the Stripe API
        try {
            $charge = Charge::create([
                'amount' => $totalAmountInCents,
                'currency' => 'usd',
                'source' => $stripeToken,
                'description' => 'Your description of the charge',
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occurred during the charge attempt
            // e.g., return an error message to the user
            return back()->withErrors('Error processing payment: ' . $e->getMessage());
        }

        // Update the payment status of the order
        $order->payment_status = 'paid';
        $order->save();

        // Redirect to the "Thank you" page after a successful charge
        return redirect()->route('order.thankyou', $order->id);
    }
}
