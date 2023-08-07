<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\customers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{

    public function Register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|between : 8,255|confirmed',
                'phone_number' => 'required',
                'address' => 'required|string|max:255'
            ]);

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password'])
            ]);

            $customer = customers::create([
                'phone_number' => $request['phone_number'],
                'address' => $request['address'],
                'user_id' => $user->id
            ]);

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'customer' => $customer,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'required|min:8|string|confirmed',
        'phone_number' => 'required',
        'address' => 'required|string|max:255',
    ]);
    try {
        // Retrieve the user data from the users table
        $user = User::findOrFail($id);

        // Update the relevant fields of the user data based on the request data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        // Save the changes to the users table
        $user->save();

        // Retrieve the customer data from the customers table
        $customer = customers::where('user_id', $id)->firstOrFail();

        // Update the relevant fields of the customer data based on the request data
        $customer->phone_number = $request->input('phone_number');
        $customer->address = $request->input('address');

        // Save the changes to the customers table
        $customer->save();

        return response()->json([
            'user' => $user,
            'customer' => $customer,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    return response()->json([
        'message' => 'User and customer data updated successfully.',
        'user' => $user,
        'customer' => $customer,
    ]);
    
}
public function deleteUser($id)
{
    try {
        // Retrieve the user data from the database
        $user = User::findOrFail($id);

        // Delete the user data
        $user->delete();

        // Retrieve the customer data from the database
        $customer = customers::where('user_id', $id)->first();

        // Delete the customer data
        $customer->delete();

        return response()->json([
            'message' => 'User and customer data deleted successfully.',
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function login(Request $request){
    try {
        $validateUser = Validator::make($request->all(), 
        [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


}
