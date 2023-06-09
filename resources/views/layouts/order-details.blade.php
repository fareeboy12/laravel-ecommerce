@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col-12 col-sm-3">
            <p><b>First Name: </b>{{$order->first_name}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Last Name: </b>{{$order->last_name}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Company: </b>{{$order->company}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Address 1: </b>{{$order->address1}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Address 2: </b>{{$order->address2}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>City: </b>{{$order->city}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Postal Code: </b>{{$order->postcode}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>State: </b>{{$order->state}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Country: </b>{{$order->country}}</p>
        </div>
        <div class="col-12 col-sm-3">
            <p><b>Email: </b>{{$order->email}}</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <table class="table table-hover" id="order-details">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Title</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><a href="/product/{{ $orderItem->product->slug }}" target="_blank"><img class="img-fluid" height="50" width="50" alt="{{ $orderItem->product->title }}" src="{{ asset('storage/' . $orderItem->product->thumbnail) }}" /></a></td>
                        <td><a href="/product/{{ $orderItem->product->slug }}" target="_blank">{{ $orderItem->product->title }}</a></td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>${{ $orderItem->product->price }}</td>
                        <td>${{ $orderItem->quantity * $orderItem->product->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="mt-5">
                    <tr>
                        <th scope="col">Coupon Amount</th>
                        <th scope="col">Shipping Fee</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Customer Note</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Grand Total</th>
                    </tr>
                    <tr>
                        <td>-${{$order->coupon_price}}</td>
                        <td>${{$order->shipping_fee}}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                        <td>{{$order->notes}}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</td>
                        <td><b>${{$order->total}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection