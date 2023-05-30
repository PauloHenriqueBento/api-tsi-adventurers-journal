<?php

use App\Http\Controllers\Api\AtividadeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItensPedidoController;
use App\Http\Controllers\Api\ModalidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaisController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\CidadeController;
use App\Http\Controllers\Api\DestinoController;
use App\Http\Controllers\Api\AssinaturaController;


Route::apiResource('/pais', PaisController::class);
Route::apiResource('/estado', EstadoController::class);
Route::apiResource('/cidade', CidadeController::class);

Route::apiResource('/modalidades', ModalidadeController::class);
Route::apiResource('Api/destino', DestinoController::class);

Route::apiResource('Api/assinatura', AssinaturaController::class);




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

Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/user/', [UserController::class, 'update']);
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rotas para a entidade "Atividade"
    // Application/Json
    Route::get('/atividades', [AtividadeController::class, 'index']);
    Route::get('/atividades/user', [AtividadeController::class, 'listByUser']);
    Route::get('/atividades/{atividade}', [AtividadeController::class, 'show']);
    Route::post('/atividades', [AtividadeController::class, 'store']);
    Route::put('/atividades/{atividade}', [AtividadeController::class, 'update']);
    Route::delete('/atividades/{atividade}', [AtividadeController::class, 'delete']);


    Route::apiResource('/itensdopedido', ItensPedidoController::class);
});
