<?php

namespace App\Http\Controllers;

use App\Models\customers;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customers $customers)
    {
        //
    }
    public function getAllCustomers()
{
    try {
        // Retrieve all customers' data from the database
        $customers = customers::all();

        return response()->json([
            'customers' => $customers,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function getCustomer($id)
{
    try {
        // Retrieve the customer/user data from the database
        $customer = customers::where('user_id', $id)->first();

        // Check if the customer/user exists
        if ($customer) {
            return response()->json([
                'customer' => $customer,
            ]);
        } else {
            return response()->json([
                'message' => 'Customer not found.',
            ], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
