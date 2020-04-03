<?php

use Illuminate\Support\Facades\Route;

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

Route::get('registerbuyer', 'RegisterController@createBuyer'); 
Route::get('registeradmin', 'RegisterController@createAdmin')->middleware('verifyadmin');
Route::get('registerowner', 'RegisterController@createOwner'); 
//Route::get('loginbuyer', 'LoginController@buyerLogin')->middleware('guest:buyer')->middleware('guest:admin')->middleware('guest:owner');
//Route::get('loginadmin', 'LoginController@adminLogin')->middleware('guest:buyer')->middleware('guest:admin')->middleware('guest:owner');
//Route::get('loginowner', 'LoginController@ownerLogin')->middleware('guest:buyer')->middleware('guest:admin')->middleware('guest:owner');
Route::get('logout','LoginController@logout');
Route::get('login','LoginController@login')->middleware('guest:buyer')->middleware('guest:admin')->middleware('guest:owner');
Route::get('getallusers','UserController@getAllusers')->middleware('verifyadmin');
Route::get('test','LoginController@test');
