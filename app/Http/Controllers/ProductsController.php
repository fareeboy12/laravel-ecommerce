<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllProducts()
    {
        $products = Products::all();
        return view('products', compact('products'));
    }

    public function getSpecificProduct($title)
    {
        // Replace hyphens with spaces
        $string = str_replace('-', ' ', $title);

        // Capitalize the first letter of each word
        $newTitle = ucwords($string);

        $product = Products::where('title', $newTitle)->first();
        return view('single-product', compact('product'));
    }

    public function addNewProduct()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Products;
        $product->title = $request->input('product_title');
        $product->stock = $request->input('product_stock');
        $product->description = $request->input('product_description');
        $product->price = $request->input('product_price');
        $product->sale_price = $request->input('product_sale_price');
        $product->category = $request->input('product_category');
        $product->brand = $request->input('product_brand');
        $product->upsell_items = $request->input('upsell_items');
        $product->crosssell_items = $request->input('crosssell_items');
        // $product->thumbnail = $request->input('featured_image');
        // $product->gallery_images = $request->input('gallery_images');
        // Add any other fields you want to save here
    
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('public/assets/images/products');
            $product->thumbnail = str_replace('public', 'storage', $featuredImagePath);
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $request->file('gallery_images');
            $galleryImagePaths = [];

            foreach ($galleryImages as $galleryImage) {
                $galleryImagePath = $galleryImage->store('public/assets/images/products');
                $galleryImagePaths[] = str_replace('public', 'storage', $galleryImagePath);
            }

            // Save gallery image paths as a JSON string
            $product->gallery_images = json_encode($galleryImagePaths);
        }

        $product->save();
    
        return redirect('/products')->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
