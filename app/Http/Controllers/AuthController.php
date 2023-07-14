<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\customers;


class AuthController extends Controller
{

    public function Register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|string|confirmed',
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

}
