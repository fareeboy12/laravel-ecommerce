<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">
    <h2 style="color: #333; font-size: 22px; margin-bottom: 20px;">Order Confirmation</h2>

    <p>Dear {{ $order->first_name }} {{ $order->last_name }},</p>

    <p>Thank you for your order. We will deliver your items soon.</p>

    <h3 style="color: #333; font-size: 18px; margin-top: 30px; margin-bottom: 15px;">Order Details:</h3>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5;">Product</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5;">Quantity</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5;">Price</th>
        </tr>
        @foreach ($order->orderItems as $orderItem)
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ $orderItem->product->title }}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ $orderItem->quantity }}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">${{ $orderItem->product->price }}</td>
        </tr>
        @endforeach
    </table>

    <p style="margin-top:30px;"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>

    <h3 style="color: #333; font-size: 18px; margin-top: 30px; margin-bottom: 15px;">Shipping Address:</h3>
    <p>{{ $order->address1 }}</p>
    <p>{{ $order->address2 }}</p>
    <p>{{ $order->city }}, {{ $order->state }}, {{ $order->postcode }}</p>
    <p>{{ $order->country }}</p>

    <div style="margin-top: 30px;">
        <p><b>Order Status:</b> {{ strtoupper($orderStatus) }}</p>
        @php
            $formattedPaymentMethod = ucwords(str_replace(['_', '-'], ' ', $paymentMethod));
        @endphp
        <p><b>Payment Method:</b> {{ $formattedPaymentMethod }}</p>

        @if ($paymentMethod === 'credit_card')
            <p><b>Payment Status:</b> {{ strtoupper($paymentStatus) }}</p>
        @endif
        <p><b>Total Amount:</b> ${{ $order->total }}</p>
    </div>

    <p>If you have any questions, please contact our customer support.</p>

    <p style="font-weight: bold; margin-top: 20px;">Thank you and have a great day!</p>
</body>
</html>
