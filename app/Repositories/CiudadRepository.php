<?php
namespace App\Repositories;

use App\Models\Ciudad;
use App\DTOs\Ciudades\CiudadDTO;
use App\Contracts\Repositories\CiudadRepositoryInterface;
use Illuminate\Support\Collection; // ← Cambia aquí

class CiudadRepository implements CiudadRepositoryInterface
{
    public function __construct(
        protected Ciudad $model
    ) {}

    public function getAllAsCollection(): Collection
    {
        return $this->model
            ->orderBy('ciudad')
            ->get()
            ->map(fn($ciudad) => CiudadDTO::fromModel($ciudad));
    }

    public function findById(string $id, bool $withDepartment = false): ?CiudadDTO
    {
        $query = $this->model->newQuery();

        if ($withDepartment) {
            $query->with('departamento');
        }

        $ciudad = $query->find($id);

        return $ciudad ? CiudadDTO::fromModel($ciudad) : null;
    }

    public function getByDepartmentAsCollection(string $departmentId): Collection
    {
        return $this->model
            ->where('id_departamento', $departmentId)
            ->orderBy('ciudad')
            ->get()
            ->map(fn($ciudad) => CiudadDTO::fromModel($ciudad));
    }
}
