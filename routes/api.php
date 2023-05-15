<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModalidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaisController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\CidadeController;


Route::apiResource('/pais', PaisController::class);
Route::apiResource('Api/estado', EstadoController::class);
Route::apiResource('Api/cidade', CidadeController::class);

Route::apiResource('/modalidades', ModalidadeController::class);

Route::get('/', function () {
    return response()->json([
        'sucess' => true,
    ]);
});

// Route::group(['middleware' => 'web'], function () {
//     Route::get('/csrf_token', function () {
//         return response()->json([
//             'token' => csrf_token(),
//         ]);
//     });
// });

Route::post('/auth/register', [AuthController::class, 'createUser']);

Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::patch('/user/', [UserController::class, 'update']);
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
