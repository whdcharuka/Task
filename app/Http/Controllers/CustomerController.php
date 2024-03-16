<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;
// use App\Http\Middleware\RoleAuthenticated;

class CustomerController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('role.auth:1', ['only' => ['addcustomer']]);
    //     $this->middleware('role.auth:2', ['only' => ['editcustomer']]);
    //     $this->middleware('role.auth:1', ['only' => ['deletecustomer']]);
    // }

    public function addcustomer(Request $request){
        // Validate request data
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|max:255',
            'phone'=>'required',
            'address'=>'required',
            'role'=>'required|numeric', // Ensure role is a number
            'taskid'=>'required|numeric'
        ]);

        // Check if the user's role allows adding customers
        if ($request->role != 1 || $request->taskid != 1) { // Use '!=' for comparison
            return response()->json(['error' => 'You do not have permission to add customers'], 403);
        }

        // Create the customer
        $customer=Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ]);

        $token=$customer->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Customer added successfully ',
            'token'=>$token,
            'token_type'=>'Bearer',
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ],201);
    }

    public function editcustomer(Request $request){
        // Validate request data
        $request->validate([
            'email'=>'required',
            'role'=>'required|numeric', // Ensure role is a number
            'taskid'=>'required|numeric'
        ]);

        // Check if the user's role allows editing customers
        if ($request->role != 2 || $request->taskid != 2) {
            return response()->json(['error' => 'You do not have permission to edit customers'], 403);
        }

        // Find and edit the customer
        $customer = Customer::where('email', $request->email)->first(); // Use 'find' method to get the customer by email

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Perform editing logic here

        $token=$customer->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Customer edited successfully',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function deletecustomer(Request $request){
        // Validate request data
        $request->validate([
            'role' => 'required|numeric',
            'email' => 'required|email',
            'taskid'=>'required|numeric'
        ]);

        // Check if the user's role allows deleting customers
        if ($request->role != 2 || $request->taskid != 3) {
            return response()->json(['error' => 'You do not have permission to delete customers'], 403);
        }

        // Find the customer by email
        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Delete the customer's tokens
        $customer->tokens()->delete();

        return response([
            'message' => 'Customer removed successfully'
        ], 201);
    }

}