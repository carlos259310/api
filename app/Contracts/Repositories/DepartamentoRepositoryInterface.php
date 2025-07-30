<?php


namespace App\Contracts\Repositories;

use App\DTOs\Departamentos\DepartamentoDTO;
use Illuminate\Support\Collection;

interface DepartamentoRepositoryInterface
{
    public function getAllAsCollection(): Collection;
    public function findById(string $id, bool $withDepartment = false): ?DepartamentoDTO;
}