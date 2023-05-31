<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\APIController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::post('/register', [LoginController::class, 'register']);  
Route::post('/login', [LoginController::class, 'Login']);  

Route::middleware('auth:sanctum')->get('/records', [APIController::class, 'index']);
Route::middleware('auth:sanctum')->delete('/records/delete/{id}', [APIController::class, 'delete']);
Route::middleware('auth:sanctum')->patch('/records/update', [APIController::class, 'update']);

Route::middleware('auth:sanctum')->get('/endpoint', function () {
    // Accessible only if the token is authenticated
});

