<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:customers,phone_number',
            'email' => 'required|string|unique:customers,email',
            'password' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], 422);
        }
        $customer = Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        $credentials = $request->only('phone_number', 'password');
        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Customer::where('phone_number', $request->phone_number)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['status' => true, 'message' => 'Login Successfully', 'token' => $token], 200);
        }
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }

    public function Logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        Auth::guard('customer')->logout();
        return response()->json(['status' => true, 'message' => 'Logged Out Successfully'],200);
    }
}
