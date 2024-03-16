<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('owner',function(){
    return view('owner');
})->name('owner')->middleware('owner');

Route::get('manager',function(){
    return view('manager');
})->name('manager')->middleware('manager');

Route::get('cashier',function(){
    return view('cashier');
})->name('cashier')->middleware('cashier');