<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::middleware('auth:sanctum')->post('/user/purchase/product', [ProductController::class, 'purchaseProduct']);
Route::middleware('auth:sanctum')->get('/user/{user}/achievements', [AchievementController::class, 'getUserAchievementDetails']);


//Todo - Move to controller
Route::post('/login', function (Request $request) {
    if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
        $user = Auth::user();
        return ['token' => $user->createToken('Token')->plainTextToken];
    }
});