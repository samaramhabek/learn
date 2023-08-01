<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\loginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product',[ProductController::class,'index']);
Route::post('product/store',[ProductController::class,'store']);
Route::put('test/{id}/update',[ProductController::class,'update']);
Route::post('login',[loginController::class,'login']);
Route::post('logout',[loginController::class,'logout'])->middleware('auth:sanctum');
