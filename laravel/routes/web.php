<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);
Route::get('logout', [UserController::class,'logout']);
Route::post('userdata', [UserController::class,'getuserdata']);
Route::post('createuser', [UserController::class,'createuser']);


