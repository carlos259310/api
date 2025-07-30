<?php
// app/Contracts/Repositories/ContribuyenteRepositoryInterface.php
namespace App\Contracts\Repositories;

use App\DTOs\Ciudades\CiudadDTO;
use Illuminate\Support\Collection; // ← Cambia aquí

interface CiudadRepositoryInterface
{

    public function getAllAsCollection(): Collection;
    public function findById(string $id, bool $withDepartment = false): ?CiudadDTO;
    public function getByDepartmentAsCollection(string $departmentId): Collection;
}
