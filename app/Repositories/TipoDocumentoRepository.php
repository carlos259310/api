<?php


namespace App\Repositories;

use App\Models\TipoDocumento;
use App\DTOs\TiposDocumentos\TipoDocumentoDTO;
use App\Contracts\Repositories\TipoDocumentoRepositoryInterface;
use Illuminate\Support\Collection; 

class TipoDocumentoRepository implements TipoDocumentoRepositoryInterface
{
    public function __construct(
        protected TipoDocumento $model
    ) {}

    public function getAllAsCollection(): Collection
    {
        return $this->model
            ->orderBy('documento')
            ->get()
            ->map(fn($tipoDocumento) => TipoDocumentoDTO::fromModel($tipoDocumento));
    }

    public function findById(string $id, bool $withDepartment = false): ?TipoDocumentoDTO
    {
        $tipoDocumento = $this->model->find($id);

        return $tipoDocumento ? TipoDocumentoDTO::fromModel($tipoDocumento) : null;
    }
}
