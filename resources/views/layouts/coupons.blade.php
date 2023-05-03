@extends('layouts.app')

@section('title', 'Add Coupon')

@section('content')

<div class="row justify-content-center">
    <h1 class="my-5">Add New Coupon</h1>
    <div class="col-12 my-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('coupons.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="">
                    @error('coupon_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="coupon_price">Coupon Price</label>
                    <input type="number" class="form-control" id="coupon_price" name="coupon_price" placeholder="">
                    @error('coupon_price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Add Coupon</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
        <h3>All Coupons</h3>
        <table class="table" id="coupons">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Coupon Code</th>
                <th scope="col">Coupon Price</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr data-id="{{ $coupon->id }}">
                        <th scope="row" class="p-2">{{ $loop->iteration }}</th>
                        <td class="p-2">
                            <input type="text" name="coupon_code" value="{{ $coupon->coupon_code }}" class="form-control m-0 edit-input" disabled>
                        </td>
                        <td class="p-2">
                            <input type="number" name="coupon_price" value="{{ $coupon->coupon_price }}" class="form-control m-0 edit-input" disabled>
                        </td>
                        <td class="p-2">
                            <button type="button" class="btn-edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button type="button" class="btn-save" style="display: none;">
                                <i class="far fa-save"></i>
                            </button>
                        </td>
                        <td class="p-2">
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">
                                    <i class="icon-close"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
