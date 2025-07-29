<?php
// routes/api.php
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Support\Facades\Route;


// Rutas de productos solo con prefijo v1

Route::prefix('v1')->group(function () {
    Route::apiResource('productos', ProductoController::class);
    Route::get('productos/search/{query}', [ProductoController::class, 'search']);
});