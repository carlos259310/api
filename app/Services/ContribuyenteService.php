<?php
// app/Services/ContribuyenteService.php
namespace App\Services;

use App\Contracts\Repositories\ContribuyenteRepositoryInterface;
use App\DTOs\Contribuyentes\ContribuyenteDTO;
use App\DTOs\Contribuyentes\CreateContribuyenteDTO;
use App\DTOs\Contribuyentes\UpdateContribuyenteDTO;
use App\Exceptions\Contribuyentes\ContribuyenteNotFoundException;
use App\Exceptions\Contribuyentes\ContribuyenteDuplicateDocumentException;
use App\Exceptions\Contribuyentes\ContribuyenteDuplicateEmailException;
use Illuminate\Pagination\LengthAwarePaginator;

class ContribuyenteService
{
    public function __construct(
        private readonly ContribuyenteRepositoryInterface $repository
    ) {}

    public function getAllContribuyentes(int $perPage = 15, bool $withRelations = true): LengthAwarePaginator
    {
        return $this->repository->getAll($perPage, $withRelations);
    }

    public function getContribuyenteById(int $id, bool $withRelations = true): ContribuyenteDTO
    {
        $contribuyente = $this->repository->findById($id, $withRelations);

        if (!$contribuyente) {
            throw new ContribuyenteNotFoundException("Contribuyente con ID {$id} no encontrado");
        }

        return $contribuyente;
    }

    public function getContribuyenteByDocument(string $documento): ContribuyenteDTO
    {
        $contribuyente = $this->repository->findByDocument($documento);

        if (!$contribuyente) {
            throw new ContribuyenteNotFoundException("Contribuyente con documento {$documento} no encontrado");
        }

        return $contribuyente;
    }

    public function createContribuyente(CreateContribuyenteDTO $dto): ContribuyenteDTO
    {
        // Validar documento único
        if ($this->repository->findByDocument($dto->documento)) {
            throw new ContribuyenteDuplicateDocumentException("Ya existe un contribuyente con el documento {$dto->documento}");
        }

        // Validar email único
        if ($this->repository->findByEmail($dto->email)) {
            throw new ContribuyenteDuplicateEmailException("Ya existe un contribuyente con el email {$dto->email}");
        }

        return $this->repository->create($dto);
    }

    public function updateContribuyente(int $id, UpdateContribuyenteDTO $dto): ContribuyenteDTO
    {
        // Validar que existe
        $existingContribuyente = $this->repository->findById($id);
        if (!$existingContribuyente) {
            throw new ContribuyenteNotFoundException("Contribuyente con ID {$id} no encontrado");
        }

        // Validar documento único (si se está actualizando)
        if ($dto->documento && $dto->documento !== $existingContribuyente->documento) {
            $duplicateDocument = $this->repository->findByDocument($dto->documento);
            if ($duplicateDocument && $duplicateDocument->id_contribuyente !== $id) {
                throw new ContribuyenteDuplicateDocumentException("Ya existe un contribuyente con el documento {$dto->documento}");
            }
        }

        // Validar email único (si se está actualizando)
        if ($dto->email && $dto->email !== $existingContribuyente->email) {
            $duplicateEmail = $this->repository->findByEmail($dto->email);
            if ($duplicateEmail && $duplicateEmail->id_contribuyente !== $id) {
                throw new ContribuyenteDuplicateEmailException("Ya existe un contribuyente con el email {$dto->email}");
            }
        }

        $contribuyente = $this->repository->update($id, $dto);

        if (!$contribuyente) {
            throw new ContribuyenteNotFoundException("Error al actualizar el contribuyente");
        }

        return $contribuyente;
    }

    public function deleteContribuyente(int $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new ContribuyenteNotFoundException("Contribuyente con ID {$id} no encontrado");
        }
    }

    public function searchContribuyentes(string $query, int $perPage = 15, bool $withRelations = true): LengthAwarePaginator
    {
        return $this->repository->search($query, $perPage, $withRelations);
    }

    public function getContribuyentesByCity(string $cityId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByCity($cityId, $perPage);
    }

    public function getContribuyentesByDepartment(string $departmentId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByDepartment($departmentId, $perPage);
    }

    public function getContribuyentesByDocumentType(int $documentTypeId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByDocumentType($documentTypeId, $perPage);
    }
}
