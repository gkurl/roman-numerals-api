<?php

use App\Http\Controllers\Api\ConversionController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->prefix('user')->group(function(){
    Route::post('logout',[UserController::class,'logout'])->name('user.logout');
});

//User registration for API via Laravel Sanctum
Route::post('user/register',[UserController::class,'register'])->name('user.register');
Route::post('user/login',[UserController::class,'login'])->name('user.login');

// Integer -> Roman conversion API routes
Route::middleware('auth:sanctum')->post('convert', [ConversionController::class, 'convert'])->name('api.convert');
Route::middleware('auth:sanctum')->get('recent', [ConversionController::class, 'recent'])->name('api.recent');
Route::middleware('auth:sanctum')->get('top', [ConversionController::class, 'top'])->name('api.top');


