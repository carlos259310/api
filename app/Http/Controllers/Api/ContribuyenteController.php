<?php
// app/Http/Controllers/Api/ContribuyenteController.php
namespace App\Http\Controllers\Api;

use App\DTOs\Contribuyentes\CreateContribuyenteDTO;
use App\DTOs\Contribuyentes\UpdateContribuyenteDTO;
use App\Exceptions\Contribuyentes\ContribuyenteDuplicateDocumentException;
use App\Exceptions\Contribuyentes\ContribuyenteDuplicateEmailException;
use App\Exceptions\Contribuyentes\ContribuyenteNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contribuyentes\CreateContribuyenteRequest;
use App\Http\Requests\Contribuyentes\UpdateContribuyenteRequest;
use App\Services\ContribuyenteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContribuyenteController extends Controller
{
    public function __construct(
        private readonly ContribuyenteService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');
            $withRelations = $request->boolean('with_relations', true);

            if ($search) {
                $contribuyentes = $this->service->searchContribuyentes($search, $perPage, $withRelations);
            } else {
                $contribuyentes = $this->service->getAllContribuyentes($perPage, $withRelations);
            }

            return response()->json([
                'success' => true,
                'data' => $contribuyentes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contribuyentes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $contribuyente = $this->service->getContribuyenteById($id);

            return response()->json([
                'success' => true,
                'data' => $contribuyente->toArray(),
            ]);
        } catch (ContribuyenteNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el contribuyente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(CreateContribuyenteRequest $request): JsonResponse
    {
        try {
            $dto = CreateContribuyenteDTO::fromArray($request->validated());
            $contribuyente = $this->service->createContribuyente($dto);

            return response()->json([
                'success' => true,
                'message' => 'Contribuyente creado exitosamente',
                'data' => $contribuyente->toArray(),
            ], 201);
        } catch (ContribuyenteDuplicateDocumentException | ContribuyenteDuplicateEmailException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el contribuyente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateContribuyenteRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateContribuyenteDTO::fromArray($request->validated());
            $contribuyente = $this->service->updateContribuyente($id, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Contribuyente actualizado exitosamente',
                'data' => $contribuyente->toArray(),
            ]);
        } catch (ContribuyenteNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (ContribuyenteDuplicateDocumentException | ContribuyenteDuplicateEmailException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el contribuyente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteContribuyente($id);

            return response()->json([
                'success' => true,
                'message' => 'Contribuyente eliminado exitosamente',
            ]);
        } catch (ContribuyenteNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el contribuyente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function findByDocument(Request $request): JsonResponse
    {
        $request->validate([
            'documento' => 'required|string|max:20'
        ]);

        try {
            $contribuyente = $this->service->getContribuyenteByDocument($request->documento);

            return response()->json([
                'success' => true,
                'data' => $contribuyente->toArray(),
            ]);
        } catch (ContribuyenteNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar el contribuyente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByCity(Request $request, string $cityId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $contribuyentes = $this->service->getContribuyentesByCity($cityId, $perPage);

            return response()->json([
                'success' => true,
                'data' => $contribuyentes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contribuyentes por ciudad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByDepartment(Request $request, string $departmentId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $contribuyentes = $this->service->getContribuyentesByDepartment($departmentId, $perPage);

            return response()->json([
                'success' => true,
                'data' => $contribuyentes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contribuyentes por departamento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByDocumentType(Request $request, int $documentTypeId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $contribuyentes = $this->service->getContribuyentesByDocumentType($documentTypeId, $perPage);

            return response()->json([
                'success' => true,
                'data' => $contribuyentes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contribuyentes por tipo de documento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
