<?php

use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('transaction', [TransactionController::class, 'index']);
Route::post('transaction/create', [TransactionController::class, 'create']);
Route::post('transaction/delete', [TransactionController::class, 'destroy']);
Route::post('users/getbalance', [UserController::class, 'getBalance']);
Route::post('users/updatebalance', [UserController::class, 'updateBalance']);
Route::get('users/{id}', [UserController::class, 'getUser']);
Route::post('users', [UserController::class, 'updateUser']);
