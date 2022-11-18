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
//inscription
Route::post('/register',[App\Http\Controllers\Auth\registerController::class, 'insert']);
//verification doublon mail
Route::post('/verifEmail',[App\Http\Controllers\Auth\userController::class, 'verifEmail']);

Route::post('/login',[App\Http\Controllers\Auth\loginController::class, 'login']);

Route::post('/getlist', [App\Http\Controllers\listController::class, 'getListUser']);

Route::post('/addList',[App\Http\Controllers\listController::class,'addList']);

Route::post('/addProduct',[App\Http\Controllers\listController::class,'addProduct']);

Route::post('/getProduct',[App\Http\Controllers\listController::class, 'getProduct']);
Route::post('/updateProduct',[App\Http\Controllers\listController::class, 'updateProduct']);
Route::post('/delList',[App\Http\Controllers\listController::class, 'deleteList']);
Route::post('/delProduct',[App\Http\Controllers\listController::class, 'deleteProduct']);
Route::post('/logOff',[App\Http\Controllers\Auth\userController::class, 'logOff']);