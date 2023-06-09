@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center my-5">
        <div class="col-12 col-md-10">
            <table id="manageProducts" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Categories</th>
                        <th>Brands</th>
                        <th>Stock</th>
                        <th>Stock Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="text-center align-middle">
                            <a href="/product/{{$product->slug}}/" target="_blank">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{$product->title}}" class="product-image" height="50px" width="50px">
                            </a>
                        </td>
                        <td class="align-middle"><a href="/product/{{$product->slug}}/" target="_blank" class="text-decoration-none text-dark">{{$product->title}}</a></td>
                        <td class="align-middle text-center" data-order="{{$product->price}}">${{$product->price}}</td>
                        <td class="align-middle text-center" data-order="{{$product->sale_price}}">${{$product->sale_price ? $product->sale_price : ""}}</td>
                        <td class="align-middle">{{$product->category}}</td>
                        <td class="align-middle">{{$product->brand}}</td>
                        <td class="align-middle text-center">{{$product->stock}}</td>
                        <td class="align-middle text-center">
                            @if($product->stock > 10)
                                <span class="badge badge-pill badge-success p-2">In-Stock</span>
                            @elseif($product->stock > 0)
                                <span class="badge badge-pill badge-warning p-2">Low-Stock</span>
                            @else
                            <span class="badge badge-pill badge-danger p-2">Out-of-Stock</span>
                            @endif
                        </td>
                        <td class="align-middle text-center"><a href="/update-product/{{ $product->slug }}"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection