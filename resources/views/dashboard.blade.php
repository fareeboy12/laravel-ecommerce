@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col rounded-lg bg-primary d-flex flex-column align-items-center justify-content-center mx-2 py-4 px-2 text-white">
            <p class="mb-0"><i class="fa-solid fa-layer-group fa-2xl"></i></p>
            <p class="mb-0">Today Orders</p>
            <p class="mb-0">{{ $totalOrders }}</p>
            <p class="mb-0">Cash: ${{ $cashOnDeliveryOrders }} Card: ${{ $creditCardOrders }}</p>
        </div>
        <div class="col rounded-lg bg-secondary d-flex flex-column align-items-center justify-content-center mx-2 py-4 px-2 text-white">
            <p class="mb-0"><i class="fa-solid fa-layer-group fa-2xl"></i></p>
            <p class="mb-0">Yesterday Orders</p>
            <p class="mb-0">{{ $yesterdayOrders }}</p>
            <p class="mb-0">Cash: ${{ $yesterdayCashOnDeliveryOrders }} Card: ${{ $yesterdayCreditCardOrders }}</p>
        </div>
        <div class="col rounded-lg bg-success d-flex flex-column align-items-center justify-content-center mx-2 py-4 px-2 text-white">
            <p class="mb-0"><i class="fa-solid fa-cart-shopping fa-2xl"></i></p>
            <p class="mb-0">This Month</p>
            <p class="mb-0">${{ $currentMonthSales }}</p>
        </div>
        <div class="col rounded-lg bg-info d-flex flex-column align-items-center justify-content-center mx-2 py-4 px-2 text-white">
            <p class="mb-0"><i class="fa-solid fa-calendar fa-2xl"></i></p>
            <p class="mb-0">All-Time Sales</p>
            <p class="mb-0">${{ $allTimeSales }}</p>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col p-3 mx-2 rounded-lg bg-secondary d-flex align-items-center text-white">
            <div class="icon mx-3 rounded-circle d-flex flex-column align-items-center justify-content-center" style="background-color: #ff5a1f; width: 50px; height: 50px;">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="data d-flex flex-column justify-content-center">
                <h6 class="mb-0">Total Orders</h6>
                <p class="mb-0 font-weight-bold h4">{{ $totalOrders }}</p>
            </div>
        </div>
        <div class="col p-3 mx-2 rounded-lg bg-secondary d-flex align-items-center text-white">
            <div class="icon mx-3 rounded-circle d-flex flex-column align-items-center justify-content-center" style="background-color: #3f83f8; width: 50px; height: 50px;">
                <i class="fa-solid fa-arrows-rotate"></i>
            </div>
            <div class="data d-flex flex-column justify-content-center">
                <h6 class="mb-0">Order Processing</h6>
                <p class="mb-0 font-weight-bold h4">{{ $processingOrders }}</p>
            </div>
        </div>
        <div class="col p-3 mx-2 rounded-lg bg-secondary d-flex align-items-center text-white">
            <div class="icon mx-3 rounded-circle d-flex flex-column align-items-center justify-content-center" style="background-color: #0694a2; width: 50px; height: 50px;">
                <i class="fa-solid fa-truck"></i>
            </div>
            <div class="data d-flex flex-column justify-content-center">
                <h6 class="mb-0">Orders Dispatched</h6>
                <p class="mb-0 font-weight-bold h4">{{ $dispatchedOrders }}</p>
            </div>
        </div>
        <div class="col p-3 mx-2 rounded-lg bg-secondary d-flex align-items-center text-white">
            <div class="icon mx-3 rounded-circle d-flex flex-column align-items-center justify-content-center" style="background-color: #0e9f6e; width: 50px; height: 50px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="data d-flex flex-column justify-content-center">
                <h6 class="mb-0">Orders Delivered</h6>
                <p class="mb-0 font-weight-bold h4">{{ $finishedOrders }}</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <h2>Sales Analytics:</h2>
            <div id="salesAnalytics"></div>
        </div>

        <div class="col-12 mt-5">
            <h2>Order Statistics:</h2>
            <div id="orderAnalytics"></div>
        </div>
    </div>
</div>

<script>
    const chartData = @json($chartData);
</script>


@endsection