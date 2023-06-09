<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
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
    public function store(Request $request, $product_id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'review_title' => 'required',
            'star_rating' => 'required|numeric|min:1|max:5',
            'review_description' => 'required',
        ]);

        // Create a new instance of the Review model
        $review = new Reviews();
        
        // Set the values of the review properties
        $review->user_id = Auth::id(); // Assuming you have the user_id column in the reviews table
        $review->product_id = $product_id; // Assuming you have the product_id column in the reviews table
        $review->review_title = $validatedData['review_title'];
        $review->star_rating = $validatedData['star_rating'];
        $review->review_description = $validatedData['review_description'];

        // Save the review in the database
        $review->save();

        // Store a success message in the session
        Session::flash('success', 'Review submitted successfully.');

        // Reload the page to display the success message
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
