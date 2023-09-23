<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'units'], function () {
    Route::get('', [UnitController::class, 'index']);
    Route::get('{unitId}', [UnitController::class, 'show']);
    Route::post('buy', [TransactionController::class, 'buy'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'units', 'middleware' => ['auth:sanctum', 'can:access_admin_abilities']], function () {
    Route::patch('{unitId}', [UnitController::class, 'update']);
    Route::post('', [UnitController::class, 'store']);
    Route::delete('{unitId}', [UnitController::class, 'destroy']);
});

Route::group(['prefix' => 'transactions', 'middleware' => ['auth:sanctum', 'can:access_admin_abilities']], function () {
    Route::get('', [TransactionController::class, 'index']);
    Route::get('/{userId}', [TransactionController::class, 'adminShow']);
});

Route::get('/users/purchases/{userId}', [TransactionController::class, 'show'])->middleware('auth:sanctum');
Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum', 'can:access_admin_abilities']], function () {
    Route::get('', [UserController::class, 'index']);
    Route::delete('{userId}', [UserController::class, 'destroy']);
});
