<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reviews;
use App\Jobs\ProcessCsvUpload;
use App\Events\ProductsUploadCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Brand;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllProducts()
    {
        $products = Products::paginate(10);
        return view('products', compact('products'));
    }

    public function manageProducts()
    {
        $products = Products::get();
        return view('layouts.manage-products', compact('products'));
    }

    public function updateProducts($slug)
    {
        $product = Products::where('slug', $slug)->first();
    
        if (!$product) {
            // Handle the case when the product is not found, e.g., return a 404 response
            abort(404);
        }
    
        // Get the category ids and brand ids as arrays
        $categoryIds = explode(',', $product->category_ids);
        $brandIds = explode(',', $product->brand_ids);
    
        // Retrieve all categories and brands
        $allCategories = Category::all();
        $allBrands = Brand::all();
    
        return view('layouts.update-product', compact('product', 'allCategories', 'allBrands', 'categoryIds', 'brandIds'));
    }
    
    
    public function getSpecificProduct($slug)
    {
        $product = Products::where('slug', $slug)->first();
    
        if (!$product) {
            // Handle the case when the product is not found, e.g., return a 404 response
            abort(404);
        }
    
        $user = Auth::user();
        $wishlist = null;
        $hasOrdered = false;
    
        if ($user) {
            $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $product->id)->first();
    
            // Check if the user has ordered the product
            $order = Order::where('user_id', $user->id)->whereHas('orderItems', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->first();
    
            if ($order) {
                $hasOrdered = true;
            }
        }

        // Fetch reviews for the product
        $reviews = Reviews::where('product_id', $product->id)->get();

        // Count total reviews for the product
        $totalReviews = $reviews->count();
    
        return view('single-product', compact('product', 'wishlist', 'hasOrdered', 'reviews', 'totalReviews'));
    }

    public function showBulkUploadForm()
    {
        return view('csv-upload-products');
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
        

        $csvFile = $request->file('csv_file');
        $filePath = $csvFile->store('csv_uploads');

        $numRecords = count(file($csvFile));
        $chunkSize = 100; // set the number of records to process in each chunk

        for ($start = 0; $start < $numRecords; $start += $chunkSize) {
            $end = $start + $chunkSize - 1;
            $job = new ProcessCsvUpload($filePath, $start, $end);
            // dispatch($job);
            dispatch($job->onQueue('csv-processing'));
        }

        return back()->with('success', 'CSV file uploaded and processing started.');
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
        
        // Generate slug from title
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('product_title')));

        // Check if slug already exists and add number suffix if necessary
        $existingSlugs = Products::where('slug', 'like', $slug.'%')->pluck('slug');
        if ($existingSlugs->contains($slug)) {
            $suffix = 1;
            do {
                $newSlug = $slug . '-' . $suffix++;
            } while ($existingSlugs->contains($newSlug));
            $slug = $newSlug;
        }

        // Save slug
        $product->slug = $slug;
    
        
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
    public function show($id)
    {
        $product = Products::findOrFail($id);
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $id)->first();
    
        return view('single-products', compact('product', 'wishlist'));
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
