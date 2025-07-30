<?php

namespace App\Services;

use App\Contracts\Repositories\TipoDocumentoRepositoryInterface;
use App\DTOs\TiposDocumentos\TipoDocumentoDTO;
use App\Exceptions\TiposDocumentos\TipoDocumentoNotFoundException;
use Illuminate\Support\Collection;

class TipoDocumentoService
{
    public function __construct(
        private readonly TipoDocumentoRepositoryInterface $repository
    ) {}

    public function getAllTiposDocumento(): Collection
    {
        return $this->repository->getAllAsCollection();
    }

    public function getTipoDocumentoById(string $id): TipoDocumentoDTO
    {
        $tipoDocumento = $this->repository->findById($id);
        
        if (!$tipoDocumento) {
            throw new TipoDocumentoNotFoundException("Tipo de documento con ID {$id} no encontrado");
        }
        
        return $tipoDocumento;
    }
}