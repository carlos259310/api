<?php
// app/DTOs/TipoDocumentoDTO.php
namespace App\DTOs\TiposDocumentos;

class TipoDocumentoDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $documento,
        public readonly string $codigo,
    ) {}

    public static function fromModel($tipoDocumento): self
    {
        return new self(
            id: $tipoDocumento->id_tipo_documento,
            documento: $tipoDocumento->documento,
            codigo: $tipoDocumento->codigo,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'documento' => $this->documento,
            'codigo' => $this->codigo,
        ];
    }
}
