<?php

namespace App\Contracts\Repositories;

use App\DTOs\TiposDocumentos\TipoDocumentoDTO;
use Illuminate\Support\Collection;
/**
 * Interface TipoDocumentoRepositoryInterface
 * @package App\Contracts\Repositories
 */
interface TipoDocumentoRepositoryInterface
{
    public function getAllAsCollection(): Collection;
    public function findById(string $id, bool $withDepartment = false): ?TipoDocumentoDTO;
}
