<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereIn('user_type', ['user', 'guest'])->with('orders')->get();
        $usersData = $users->map(function ($user) {
            $orderCount = $user->orders->count();
            $totalAmount = $user->orders->sum('total');
            
            return [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'order_count' => $orderCount,
                'total_amount' => $totalAmount
            ];
        });
    
        return view('layouts.all-users', ['usersData' => $usersData]);
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
        //
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
    public function update(Request $request, User $user)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'new_password' => 'nullable|min:8'
        ]);

        // Update the user's information
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->address1 = $validatedData['address1'];
        $user->address2 = $validatedData['address2'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        
        // Update the user's password if a new password is provided
        if (!empty($validatedData['new_password'])) {
            $user->password = Hash::make($validatedData['new_password']);

            // Log the user out and redirect to the login page
            Auth::logout();
            return redirect()->route('login')->with('success', 'Your password has been updated. Please log in again.');
        }

        // Save the updated user
        $user->save();

        // Redirect back to the user's profile with a success message
        return redirect()->route('accounts.index', $user->id)->with('success', 'Your profile has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
