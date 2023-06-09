@extends('layouts.app')

@section('title', 'All Orders')

@section('content')

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <table class="table table-striped table-bordered" id="orders-table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">View Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                            <td class="align-middle">{{ $order->order_number }}</td>
                            <td class="align-middle">{{ $order->created_at->format('d F, Y') }}</td>
                            <td class="align-middle">{{ $order->first_name . " " . $order->last_name }}</td>
                            <td class="align-middle">{{ $order->address1 . " " . $order->address2 }}</td>
                            <td class="align-middle" data-order="{{ $order->subtotal }}">${{ $order->subtotal }}</td>
                            <td data-order="{{ $order->order_status }}" class="align-middle">
                                @if ($order->order_status == 'processing')
                                    <span class="badge badge-secondary p-2">{{ ucfirst($order->order_status) }}</span>
                                @elseif ($order->order_status == 'dispatched')
                                    <span class="badge badge-info p-2">{{ ucfirst($order->order_status) }}</span>
                                @elseif ($order->order_status == 'finished')
                                    <span class="badge badge-success p-2">{{ ucfirst($order->order_status) }}</span>
                                @endif
                            </td>

                            <td class="align-middle">
                                <select class="custom-select custom-select-lg form-control" name="order_status" id="order_status">
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                    <option value="finished" {{ $order->order_status == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                            </td>
                            <td class="align-middle text-center cursor-pointer" data-url="/order-details/{{ $order->id }}"><i class="fa-solid fa-arrow-right"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

<style>
    .cursor-pointer:hover {
        cursor: pointer;
    }
</style>