<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DepartamentoService;

use Illuminate\Http\JsonResponse;

class DepartamentoController extends Controller
{
    public function __construct(
        protected DepartamentoService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $departamentos = $this->service->getAllDepartamentos();

            return response()->json([
                'success' => true,
                'data' => $departamentos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener departamentos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $departamento = $this->service->getDepartamentoById($id);

            return response()->json([
                'success' => true,
                'data' => $departamento->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}