<?php


namespace App\Repositories;

use App\Models\Departamento;
use App\DTOs\Departamentos\DepartamentoDTO;
use App\Contracts\Repositories\DepartamentoRepositoryInterface;
use Illuminate\Support\Collection; // ← Cambia aquí

class DepartamentoRepository implements DepartamentoRepositoryInterface
{
    public function __construct(
        protected Departamento $model
    ) {}

    public function getAllAsCollection(): Collection
    {
        return $this->model
            ->orderBy('departamento')
            ->get()
            ->map(fn($departamento) => DepartamentoDTO::fromModel($departamento));
    }



    public function findById(string $id, bool $withDepartment = false): ?DepartamentoDTO
    {
        $departamento = $this->model->find($id);

        return $departamento ? DepartamentoDTO::fromModel($departamento) : null;
    }
}
