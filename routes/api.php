<?php
// routes/api.php

use App\Http\Controllers\Api\CiudadController;
use App\Http\Controllers\Api\ContribuyenteController;
use App\Http\Controllers\Api\ContribuyenteReportController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\TiposDocumentoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Rutas de productos solo con prefijo v1

Route::prefix('v1')->group(function () {


    // Rutas de autenticación
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
    // Rutas de productos

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('productos', ProductoController::class);
        Route::get('productos/search/{query}', [ProductoController::class, 'search']);

        // Rutas de contribuyentes
        Route::apiResource('contribuyentes', ContribuyenteController::class);

        // Rutas adicionales para contribuyentes
        Route::prefix('contribuyentes')->group(function () {
            Route::post('buscar-documento', [ContribuyenteController::class, 'findByDocument']);
            Route::get('ciudad/{cityId}', [ContribuyenteController::class, 'getByCity']);
            Route::get('departamento/{departmentId}', [ContribuyenteController::class, 'getByDepartment']);
            Route::get('tipo-documento/{documentTypeId}', [ContribuyenteController::class, 'getByDocumentType']);
        });

        // Departamentos
        Route::prefix('departamentos')->group(function () {
            Route::get('/', [DepartamentoController::class, 'index']);
            Route::get('{id}', [DepartamentoController::class, 'show']);
        });

        // Ciudades
        Route::prefix('ciudades')->group(function () {
            Route::get('/', [CiudadController::class, 'index']);
            Route::get('{id}', [CiudadController::class, 'show']);
            Route::get('departamento/{departmentId}', [CiudadController::class, 'getByDepartamento']);
        });

        // Tipos de documento
        Route::prefix('tipos-documento')->group(function () {
            Route::get('/', [TiposDocumentoController::class, 'index']);
            Route::get('{id}', [TiposDocumentoController::class, 'show']);
        });



        // Nuevas rutas para reportes
        Route::prefix('reports')->group(function () {
            Route::post('contribuyentes', [ContribuyenteReportController::class, 'generateContribuyentesReport']);
            Route::get('download/{path}', [ContribuyenteReportController::class, 'downloadReport'])
                ->name('api.reports.download')
                ->where('path', '.*');
        });
    });
});
