<?php
// app/Contracts/Repositories/ContribuyenteRepositoryInterface.php
namespace App\Contracts\Repositories;

use App\DTOs\Contribuyentes\ContribuyenteDTO;
use App\DTOs\Contribuyentes\CreateContribuyenteDTO;
use App\DTOs\Contribuyentes\UpdateContribuyenteDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContribuyenteRepositoryInterface
{
    public function getAll(int $perPage = 15, bool $withRelations = false): LengthAwarePaginator;

    public function findById(int $id, bool $withRelations = false): ?ContribuyenteDTO;

    public function findByDocument(string $documento): ?ContribuyenteDTO;

    public function findByEmail(string $email): ?ContribuyenteDTO;

    public function create(CreateContribuyenteDTO $dto): ContribuyenteDTO;

    public function update(int $id, UpdateContribuyenteDTO $dto): ?ContribuyenteDTO;

    public function delete(int $id): bool;

    public function search(string $query, int $perPage = 15, bool $withRelations = false): LengthAwarePaginator;

    public function getByCity(string $cityId, int $perPage = 15): LengthAwarePaginator;

    public function getByDepartment(string $departmentId, int $perPage = 15): LengthAwarePaginator;

    public function getByDocumentType(int $documentTypeId, int $perPage = 15): LengthAwarePaginator;
}
