@extends('layouts.app')

@section('title', 'Update Product')

@section('content')

<div class="container my-5">
    <form>
        <div class="row justify-content-center">
            <div class="col-12 form-group mb-4">
                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid" alt="{{ $product->title }}" />
                <div class="custom-file mt-2">
                    <input type="file" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose New Thumbnail</label>
                </div>
            </div>
            <div class="col-12 form-group mb-4">
                <input class="form-control" type="text" name="product-title" placeholder="Product Title" value="{{ $product->title }}" required>
            </div>
            <div class="col-12 form-group mb-4">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $product->description }}</textarea>
            </div>
            <div class="col-12 col-md-6 form-group mb-4">
                <label class="sr-only" for="product-price">Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">$</div>
                    </div>
                    <input class="form-control" type="number" name="product-price" placeholder="Product Price" value="{{ $product->price }}" required>
                </div>
            </div>
            <div class="col-12 col-md-6 form-group mb-4">
                <label class="sr-only" for="product-sale-price">Sale Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">$</div>
                    </div>
                    <input class="form-control" type="number" name="product-sale-price" placeholder="Product Sale Price" value="{{ $product->sale_price }}" required>
                </div>
            </div>
            <div class="col-12 col-md-6 form-group mb-4">
                <select id="categories" class="form-control" placeholder="Categories" multiple>
                    @foreach ($allCategories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $categoryIds) ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 form-group mb-4">
                <select id="brands" class="form-control" placeholder="Brands" multiple>
                    @foreach ($allBrands as $brand)
                        <option value="{{ $brand->id }}" {{ in_array($brand->id, $brandIds) ? 'selected' : '' }}>
                            {{ $brand->brand }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-12 col-md-6 form-group mb-4">
                <select id="upsell-items" class="form-control" placeholder="Upsell Items" multiple>
                    <option value="HTML">HTML</option>
                    <option value="Jquery">Jquery</option>
                    <option value="CSS">CSS</option>
                    <option value="Bootstrap 3">Bootstrap 3</option>
                    <option value="Bootstrap 4">Bootstrap 4</option>
                    <option value="Java">Java</option>
                    <option value="Javascript">Javascript</option>
                    <option value="Angular">Angular</option>
                    <option value="Python">Python</option>
                    <option value="Hybris">Hybris</option>
                    <option value="SQL">SQL</option>
                    <option value="NOSQL">NOSQL</option>
                    <option value="NodeJS">NodeJS</option>
                </select>
            </div>
            <div class="col-12 col-md-6 form-group mb-4">
                <select id="cross-sell-items" class="form-control" placeholder="CrossSell Items" multiple>
                    <option value="HTML">HTML</option>
                    <option value="Jquery">Jquery</option>
                    <option value="CSS">CSS</option>
                    <option value="Bootstrap 3">Bootstrap 3</option>
                    <option value="Bootstrap 4">Bootstrap 4</option>
                    <option value="Java">Java</option>
                    <option value="Javascript">Javascript</option>
                    <option value="Angular">Angular</option>
                    <option value="Python">Python</option>
                    <option value="Hybris">Hybris</option>
                    <option value="SQL">SQL</option>
                    <option value="NOSQL">NOSQL</option>
                    <option value="NodeJS">NodeJS</option>
                </select>
            </div>
            <div class="col-12 form-group">
                <button type="submit" class="btn btn-primary mb-2">Update Product</button>
            </div>
        </div>
    </form>
</div>

@endsection