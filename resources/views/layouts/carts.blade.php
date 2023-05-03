@extends('layouts.app')

@section('title', 'Carts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-12">
        <h2>Cart Details</h2>
        <div class="accordion" id="cartAccordion">
            @foreach($cartItems->groupBy('user_id') as $userId => $userCartItems)
                @php($firstItem = $userCartItems->first())
                <div class="card mb-5">
                    <div class="card-header" id="heading-{{ $userId }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link pl-0" type="button" data-toggle="collapse" data-target="#collapse-{{ $userId }}" aria-expanded="true" aria-controls="collapse-{{ $userId }}">
                                {{ $firstItem->user->first_name }} {{ $firstItem->user->last_name }}
                            </button>
                        </h5>
                        <p>{{ $firstItem->user->email }} | {{ $firstItem->user->phone }}</p>
                        <p>{{ $firstItem->user->address }}</p>
                    </div>

                    <div id="collapse-{{ $userId }}" class="collapse" aria-labelledby="heading-{{ $userId }}" data-parent="#cartAccordion">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Thumbnail</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($grandTotalPrice = 0)
                                    @php($grandTotalQuantity = 0)
                                    @foreach($userCartItems as $item)
                                        <tr>
                                            <td><a href="/product/{{ $item->product->slug }}" target="_blank">{{ $item->product->title }}</a></td>
                                            <td><a href="/product/{{ $item->product->slug }}" target="_blank"><img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->title }}" style="max-width: 50px;"></a></td>
                                            <td>${{ number_format($item->product->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                        @php($grandTotalPrice += $item->product->price * $item->quantity)
                                        @php($grandTotalQuantity += $item->quantity)
                                    @endforeach
                                </tbody>
                            </table>
                            <p><strong>Coupon Code:</strong> {{ $firstItem->coupon_code }}</p>
                            <p><strong>Coupon Price:</strong> ${{ number_format($firstItem->coupon_price, 2) }}</p>
                            <p><strong>Shipping Fee:</strong> ${{ number_format($firstItem->shipping_fee, 2) }}</p>
                            <p><strong>Shipping Method:</strong> {{ $firstItem->shipping_method }}</p>
                            <p><strong>Total Quantity:</strong> {{ $grandTotalQuantity }}</p>
                            <p><strong>Total Price:</strong> ${{ number_format($grandTotalPrice, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
