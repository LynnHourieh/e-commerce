<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//PUBLIC ROUTES
Route::post("/login",[AuthController::class,"Login"]);
Route::post("/register",[AuthController::class,"Register"]);
// Route::post("/logout",[AuthController::class,"logout"]);
Route::post("/forgetpassword",[ForgetController::class,"ForgetPassword"]);
Route::post("/resetpassword",[ForgetController::class,"ResetPassword"]);

//PRIVATE ROUTES
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


