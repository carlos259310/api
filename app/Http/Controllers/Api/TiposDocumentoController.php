<?php

namespace App\Http\Controllers\Api;

use App\Services\TipoDocumentoService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TiposDocumentoController extends Controller
{
    public function __construct(
        private readonly TipoDocumentoService $service
    ) {}

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $tiposDocumento = $this->service->getAllTiposDocumento();

            return response()->json([
                'success' => true,
                'data' => $tiposDocumento,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tipos de documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $tipoDocumento = $this->service->getTipoDocumentoById($id);

            return response()->json([
                'success' => true,
                'data' => $tipoDocumento->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
