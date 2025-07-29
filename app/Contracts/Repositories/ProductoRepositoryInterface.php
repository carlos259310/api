<?php
// app/Contracts/Repositories/ProductoRepositoryInterface.php
namespace App\Contracts\Repositories;


use App\DTOs\Productos\ProductoDTO;
use App\DTOs\Productos\CreateProductoDTO;
use App\DTOs\Productos\UpdateProductoDTO;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductoRepositoryInterface
{
    public function getAll(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?ProductoDTO;

    public function create(CreateProductoDTO $dto): ProductoDTO;

    public function update(int $id, UpdateProductoDTO $dto): ?ProductoDTO;

    public function delete(int $id): bool;

    public function search(string $query, int $perPage = 15): LengthAwarePaginator;
}
