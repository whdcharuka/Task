<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\RoleAuthenticated;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class,'logout']);

Route::post('/additem', [ItemController::class,'additem']);
Route::post('/edititem', [ItemController::class,'edititem']);
Route::post('/deleteitem', [ItemController::class,'deleteitem']);

Route::post('/addcustomer', [CustomerController::class,'addcustomer']);
Route::post('/editcustomer', [CustomerController::class,'editcustomer']);
Route::post('/deletecustomer', [CustomerController::class,'deletecustomer']);

Route::post('/adduser', [UserController::class,'adduser']);
Route::post('/edituser', [UserController::class,'edituser']);
Route::post('/deleteuser', [UserController::class,'deleteuser']);

Route::post('/addtask', [TaskController::class,'addtask']);
Route::post('/edittask', [TaskController::class,'edittask']);
Route::post('/deletetask', [TaskController::class,'deletetask']);