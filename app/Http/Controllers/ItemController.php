<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\User;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function additem(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'description'=>'required|max:255',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric',
            'role'=>'required|numeric',
            'taskid'=>'required|numeric'
        ]);

        if ($request->role != 1 || $request->taskid != 4) {
            return response()->json(['error' => 'You do not have permission to add customers'], 403);
        }

        $item=Item::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
        ]);

        $token=$item->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Item added successfully ',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function edititem(Request $request){
        $request->validate([
            'id'=>'required|max:255',
            'role'=>'required|numeric',
            'taskid'=>'required|numeric'
        ]);

        if ($request->role != 3 || $request->taskid != 5) {
            return response()->json(['error' => 'You do not have permission to edit customers'], 403);
        }

        $item=Item::where('id',$request->id)->first();

        $token=$item->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Item updated successfully',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function deleteitem(Request $request){
        $request->validate([
            'id'=>'required|max:255',
            'role'=>'required|numeric',
            'taskid'=>'required|numeric'
        ]);

        $item=Item::where('id',$request->id)->first();

        if ($request->role != 3 || $request->taskid != 6) {
            return response()->json(['error' => 'You do not have permission to edit customers'], 403);
        }

        $item->tokens()->delete();

        return response([
            'message'=>'Item remove successfully'
        ],201);
    }
}
