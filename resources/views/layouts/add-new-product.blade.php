@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label for="product_title">Product Title</label>
                        <input type="text" class="form-control" id="product_title" name="product_title" placeholder="White Shirt">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="product_stock">Product Stock</label>
                        <input type="number" class="form-control" id="product_stock" name="product_stock" placeholder="50">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="product_description">Product Description</label>
                        <textarea class="form-control" id="product_description" name="product_description" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label for="product_price">Product Price</label>
                        <input type="number" class="form-control" id="product_price" name="product_price" placeholder="100">
                        
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="product_sale_price">Product Sale Price</label>
                        <input type="number" class="form-control" id="product_sale_price" name="product_sale_price" placeholder="100">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                    <label for="product_category">Product Category</label>
                        <select id="product_category" name="product_category" class="form-control" multiple>
                            <option disabled="disabled">Choose...</option>
                            <option value="1">Category 1</option>
                            <option value="1">Category 2</option>
                            <option value="1">Category 3</option>
                            <option value="1">Category 4</option>
                            <option value="1">Category 5</option>
                            <option value="1">Category 6</option>
                            <option value="1">Category 7</option>
                            <option value="1">Category 8</option>
                            <option value="1">Category 9</option>
                            <option value="1">Category 10</option>
                        </select>
                        
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="product_brand">Product Brand</label>
                        <input type="text" class="form-control" id="product_brand" name="product_brand" placeholder="Apple">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label for="upsell_items">Upsell Items</label>
                        <select id="upsell_items" name="upsell_items" class="form-control" multiple>
                            <option disabled="disabled">Choose...</option>
                            <option value="1">Category 1</option>
                            <option value="1">Category 2</option>
                            <option value="1">Category 3</option>
                            <option value="1">Category 4</option>
                            <option value="1">Category 5</option>
                            <option value="1">Category 6</option>
                            <option value="1">Category 7</option>
                            <option value="1">Category 8</option>
                            <option value="1">Category 9</option>
                            <option value="1">Category 10</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="crosssell_items">Crosssell Items</label>
                        <select id="crosssell_items" name="crosssell_items" class="form-control" multiple>
                            <option disabled="disabled">Choose...</option>
                            <option value="1">Category 1</option>
                            <option value="1">Category 2</option>
                            <option value="1">Category 3</option>
                            <option value="1">Category 4</option>
                            <option value="1">Category 5</option>
                            <option value="1">Category 6</option>
                            <option value="1">Category 7</option>
                            <option value="1">Category 8</option>
                            <option value="1">Category 9</option>
                            <option value="1">Category 10</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" class="form-control-file" id="featured_image" name="featured_image">
                    </div>
                    <div class="form-group col-12">
                        <div class="upload__box">
                            <div class="upload__btn-box">
                                <label class="upload__btn" for="gallery_images">
                                <p>Upload Gallery Product Images</p>
                                <input id="gallery_images" name="gallery_images[]" type="file" multiple="" data-max_length="20" class="upload__inputfile">
                                </label>
                            </div>
                            <div class="upload__img-wrap"></div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Add Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection