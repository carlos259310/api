<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CiudadService;
use Illuminate\Http\JsonResponse;

class CiudadController extends Controller
{
    public function __construct(
        protected CiudadService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $ciudades = $this->service->getAllCiudades();

            return response()->json([
                'success' => true,
                'data' => $ciudades->map(fn($dto) => $dto->toArray()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ciudades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $ciudad = $this->service->getCiudadById($id, withDepartment: true);

            return response()->json([
                'success' => true,
                'data' => $ciudad->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function getByDepartamento(string $departmentId): JsonResponse
    {
        try {
            $ciudades = $this->service->getCiudadesByDepartamento($departmentId);

            return response()->json([
                'success' => true,
                'data' => $ciudades->map(fn($dto) => $dto->toArray()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ciudades del departamento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
