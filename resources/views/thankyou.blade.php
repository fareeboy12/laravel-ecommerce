@include('header');
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Thank You for Your Order!</h2>
            <p class="text-center">Order Number: {{ $order->order_number }}</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <h4>Order Details:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td><img src="{{ asset($item->product->thumbnail) }}" alt="{{ $item->product->title }}" width="100" class="img-fluid"></td>
                            <td>{{ $item->product->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ $item->quantity * $item->product->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p><b>Subtotal: ${{ $order->subtotal }}</b></p>
            <p><b>Shipping Fee: ${{ $order->shipping_fee }}</b></p>
            @if($order->coupon_code)
                <p><b>Coupon ({{ $order->coupon_code }}): -$ {{ $order->coupon_price }}</b></p>
            @endif
        </div>
        <div class="col-6">
            <p class="text-right"><b>Total: ${{ $order->total }}</b></p>
        </div>
    </div>
</div>
@include('footer');
