<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaisController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\CidadeController;
use App\Http\Controllers\Api\DestinoController;

Route::apiResource('/users', UserController::class);
// Rota acima é a junção das rotas abaixo

// Route::delete('/users/{id}', [UserController::class, 'destroy']);
// Route::patch('/users/{id}', [UserController::class, 'update']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users', [UserController::class, 'store']);

Route::apiResource('/pais', PaisController::class);
Route::apiResource('Api/estado', EstadoController::class);
Route::apiResource('Api/cidade', CidadeController::class);

Route::apiResource('Api/destino', DestinoController::class);
Route::get('/', function(){
    return response()->json([
        'sucess' => true
    ]);
});
