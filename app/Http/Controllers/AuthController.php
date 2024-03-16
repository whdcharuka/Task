<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|unique:users|max:255',
            'role'=>'required|numeric', // Ensure role is a number
            'password'=>'required|max:255|min:8|string',
        ]);

        $roles = [
            1 => 'owner',
            2 => 'manager',
            3 => 'cashier',
        ];

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
            'password'=>Hash::make($request->password)
        ]);

        $roleName = $roles[$request->role] ?? 'user'; // Default to 'user' if role not found

        $token=$user->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Registered successfully as ' . $roleName,
            'token'=>$token,
            'role'=>$user->role,
            'token_type'=>'Bearer'
        ],201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $user=User::where('email',$request->email)->first();

        if(!$user||!Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'message'=>['Credentials are incorrect']
            ]);
        }

        $roles = [
            1 => 'owner',
            2 => 'manager',
            3 => 'cashier',
        ];

        $roleName = $roles[$user->role] ?? 'user'; // Default to 'user' if role not found

        $token=$user->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Logged in successfully as ' . $roleName,
            'token'=>$token,
            'role'=>$user->role,
            'token_type'=>'Bearer'
        ],201);
    }

        public function logout(Request $request){

            $request->user()->tokens()->delete();

            return response([
                'message'=>'Logged out successfully'
            ],201);
        }
}