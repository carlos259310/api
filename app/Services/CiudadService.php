<?php

namespace App\Services;


use App\Contracts\Repositories\CiudadRepositoryInterface;
use App\DTOs\Ciudades\CiudadDTO;
use App\Exceptions\Ciudades\CiudadNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class CiudadService
{

    public function __construct(private readonly CiudadRepositoryInterface $repository) {}


    public function getAllCiudades()
    {
        return $this->repository->getAllAsCollection();
    }

  public function getCiudadById(string $id, bool $withDepartment = false): CiudadDTO
    {
        $ciudad = $this->repository->findById($id, $withDepartment);
        
        if (!$ciudad) {
            throw new CiudadNotFoundException("Ciudad con ID {$id} no encontrada");
        }
        
        return $ciudad;
    }

    public function getCiudadesByDepartamento(string $departmentId): Collection
    {
        $result = $this->repository->getByDepartmentAsCollection($departmentId);

      
        if (!$result instanceof Collection) {
            $result = new Collection($result->all());
        }

        return $result;
    }
}
