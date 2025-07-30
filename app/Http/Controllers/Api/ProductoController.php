<?php
// app/Http/Controllers/Api/ProductoController.php
namespace App\Http\Controllers\Api;

use App\DTOs\Productos\CreateProductoDTO; 
use App\DTOs\Productos\UpdateProductoDTO;
use App\Exceptions\Productos\ProductoNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Productos\CreateProductoRequest;
use App\Http\Requests\Productos\UpdateProductoRequest;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct(
        private readonly ProductoService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');

            $productos = $search 
                ? $this->service->searchProductos($search, $perPage)
                : $this->service->getAllProductos($perPage);

            return response()->json([
                'success' => true,
                'data' => $productos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function search(string $query): JsonResponse
    {
        try {
            $productos = $this->service->searchProductos($query);

            return response()->json([
                'success' => true,
                'data' => $productos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda de productos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $producto = $this->service->getProductoById($id);

            return response()->json([
                'success' => true,
                'data' => $producto->toArray(),
            ]);
        } catch (ProductoNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el producto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(CreateProductoRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductoDTO::fromArray($request->validated());
            $producto = $this->service->createProducto($dto);

            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $producto->toArray(),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateProductoRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateProductoDTO::fromArray($request->validated());
            $producto = $this->service->updateProducto($id, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'data' => $producto->toArray(),
            ]);
        } catch (ProductoNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteProducto($id);

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente',
            ]);
        } catch (ProductoNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}