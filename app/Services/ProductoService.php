<?php
// app/Services/ProductoService.php
namespace App\Services;

use App\Contracts\Repositories\ProductoRepositoryInterface;
use App\DTOs\Productos\CreateProductoDTO;
use App\DTOs\Productos\UpdateProductoDTO;
use App\DTOs\Productos\ProductoDTO;
use App\Exceptions\Productos\ProductoNotFoundException;
use App\Exceptions\Productos\ProductoNotFoundException as ProductosProductoNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductoService
{
    public function __construct(
        private readonly ProductoRepositoryInterface $repository
    ) {}

    public function getAllProductos(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAll($perPage);
    }

    public function getProductoById(int $id): ProductoDTO
    {
        $producto = $this->repository->findById($id);
        
        if (!$producto) {
            throw new ProductosProductoNotFoundException("Producto con ID {$id} no encontrado");
        }
        
        return $producto;
    }

    public function createProducto(CreateProductoDTO $dto): ProductoDTO
    {
        return $this->repository->create($dto);
    }

    public function updateProducto(int $id, UpdateProductoDTO $dto): ProductoDTO
    {
        $producto = $this->repository->update($id, $dto);
        
        if (!$producto) {
            throw new ProductoNotFoundException("Producto con ID {$id} no encontrado");
        }
        
        return $producto;
    }

    public function deleteProducto(int $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new ProductoNotFoundException("Producto con ID {$id} no encontrado");
        }
    }

    public function searchProductos(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->search($query, $perPage);
    }
}