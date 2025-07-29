<?php
// app/Repositories/ProductoRepository.php
namespace App\Repositories;

use App\Contracts\Repositories\ProductoRepositoryInterface;
use App\DTOs\Productos\CreateProductoDTO;
use App\DTOs\Productos\ProductoDTO;
use App\DTOs\Productos\UpdateProductoDTO;
use App\Models\Producto;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductoRepository implements ProductoRepositoryInterface
{
    public function __construct(
        private readonly Producto $model
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?ProductoDTO
    {
        $producto = $this->model->find($id);

        return $producto ? ProductoDTO::fromModel($producto) : null;
    }

    public function create(CreateProductoDTO $dto): ProductoDTO
    {
        $producto = $this->model->create($dto->toArray());

        return ProductoDTO::fromModel($producto);
    }

    public function update(int $id, UpdateProductoDTO $dto): ?ProductoDTO
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            return null;
        }

        $producto->update($dto->toArray());

        return ProductoDTO::fromModel($producto->fresh());
    }

    public function delete(int $id): bool
    {
        $producto = $this->model->find($id);

        return $producto ? $producto->delete() : false;
    }

    public function search(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('descripcion', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
