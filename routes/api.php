<?php

use App\Http\Controllers\CardController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\AuthController;

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
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('card/{url}', [CardController::class,'url']);

Route::get('show/cards', [CardController::class,'cards']);

Route::middleware('auth:sanctum')->group( function () {

    Route::get('user', [AuthController::class, 'index']);

    Route::post('update', [AuthController::class, 'update']);

    Route::resource('cards', CardController::class);

    Route::resource('tasks', TaskController::class);
});


Route::post('register', [AuthController::class, 'register']);
