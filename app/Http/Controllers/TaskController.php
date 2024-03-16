<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Usertask;

class TaskController extends Controller
{
    public function addtask(Request $request){
        $request->validate([
            'taskid'=>'required|max:255|numeric',
            'taskname'=>'required|max:255',
            'role'=>'required|max:255|numeric',
        ]);

        $usertask=Usertask::create([
            'taskid'=>$request->taskid,
            'taskname'=>$request->taskname,
            'role'=>$request->role,
        ]);

        $token=$usertask->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Task added successfully ',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function edittask(Request $request){
        $request->validate([
            'taskid'=>'required|max:255',
        ]);

        $usertask=Usertask::where('taskid',$request->taskid)->first();

        $token=$usertask->createToken('auth_token')->plainTextToken;

        return response([
            'message'=>'Task updated successfully',
            'token'=>$token,
            'token_type'=>'Bearer'
        ],201);
    }

    public function deletetask(Request $request){
        $request->validate([
            'taskid'=>'required|max:255',
        ]);

        $usertask=Usertask::where('taskid',$request->taskid)->first();

        $usertask->tokens()->delete();

        return response([
            'message'=>'Task remove successfully'
        ],201);
    }
}
