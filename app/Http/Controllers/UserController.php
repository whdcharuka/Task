<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userrole;

class UserController extends Controller
{
    public function adduser(Request $request){
        $request->validate([
            'role'=>'required|max:255|numeric',
            'rolename'=>'required|max:255',
        ]);

        $userrole=Userrole::create([
            'role'=>$request->role,
            'rolename'=>$request->rolename,
        ]);

        $token=$userrole->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Userrole added successfully ',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function edituser(Request $request){
        $request->validate([
            'role'=>'required|max:255|numeric',
        ]);

        $userrole=Userrole::where('role',$request->role)->first();

        $token=$userrole->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Userrole updated successfully',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function deleteuser(Request $request){
        $request->validate([
            'role'=>'required|max:255|numeric',
        ]);

        $userrole=Userrole::where('role',$request->role)->first();

        $userrole->tokens()->delete();

        return response([
            'message'=>'Userrole remove successfully'
        ],201);
    }
}
