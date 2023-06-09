@extends('layouts.app')

@section('title', 'All Users')

@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <table class="table table-hover table-sm" id="all-users">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Total Orders</th>
                    <th scope="col">Total Amount Spent</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersData as $userData)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $userData['first_name'] }}</td>
                        <td>{{ $userData['last_name'] }}</td>
                        <td data-order="{{ $userData['order_count'] }}">{{ $userData['order_count'] }}</td>
                        <td data-order="{{ $userData['total_amount'] }}">${{ $userData['total_amount'] }}</td>
                        <td><a href="#"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection