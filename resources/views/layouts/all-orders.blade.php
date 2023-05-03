@extends('layouts.app')

@section('title', 'All Orders')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 mt-5">
        <table class="table table-hover" id="orders-table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Order No.</th>
                <th scope="col">Date</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Address</th>
                <th scope="col">Total QTY</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $statusClass = '';
                        if ($order->order_status == 'processing') {
                            $statusClass = 'table-primary';
                        } elseif ($order->order_status == 'dispatched') {
                            $statusClass = 'table-warning';
                        } elseif ($order->order_status == 'finished') {
                            $statusClass = 'table-success';
                        }
                    @endphp
                    <tr class="{{ $statusClass }}">
                        <th scope="row" class="align-middle" data-url="/order-details/{{ $order->id }}">{{ $loop->iteration }}</th>
                        <td data-url="/order-details/{{ $order->id }}">{{ $order->order_number }}</td>
                        <td data-url="/order-details/{{ $order->id }}">{{ $order->created_at->format('d F, Y') }}</td>
                        <td data-url="/order-details/{{ $order->id }}">{{ $order->first_name . " " . $order->last_name }}</td>
                        <td data-url="/order-details/{{ $order->id }}">{{ $order->address1 . " " . $order->address2 }}</td>
                        <td data-url="/order-details/{{ $order->id }}">{{ $order->total_qty }}</td>
                        <td data-url="/order-details/{{ $order->id }}">${{ $order->subtotal }}</td>
                        <td>
                            <select class="custom-select custom-select-lg" name="order_status" id="order_status">
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                <option value="finished" {{ $order->order_status == 'finished' ? 'selected' : '' }}>Finished</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection