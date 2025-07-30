<?php


namespace App\Services;

use App\Contracts\Repositories\DepartamentoRepositoryInterface;
use App\DTOs\Departamentos\DepartamentoDTO;
use App\Exceptions\Departamentos\DepartamentoNotFoundException;
use Illuminate\Support\Collection;

class DepartamentoService
{
    public function __construct(
        private readonly DepartamentoRepositoryInterface $repository
    ) {}

    public function getAllDepartamentos(): Collection
    {
        return $this->repository->getAllAsCollection();
    }

    public function getDepartamentoById(string $id): DepartamentoDTO
    {
        $departamento = $this->repository->findById($id);
        
        if (!$departamento) {
            throw new DepartamentoNotFoundException("Departamento con ID {$id} no encontrado");
        }
        
        return $departamento;
    }
}