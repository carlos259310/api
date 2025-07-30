<?php
// app/DTOs/CiudadDTO.php
namespace App\DTOs\Ciudades;

class CiudadDTO
{
    public function __construct(
        public readonly string $id_ciudad,
        public readonly string $ciudad,
        public readonly string $id_departamento,
    ) {}

    public static function fromModel($ciudad): self
    {
        return new self(
            id_ciudad: $ciudad->id_ciudad,
            ciudad: $ciudad->ciudad,
            id_departamento: $ciudad->id_departamento,
        );
    }

    public function toArray(): array
    {
        return [
            'id_ciudad' => $this->id_ciudad,
            'ciudad' => $this->ciudad,
            'id_departamento' => $this->id_departamento,
        ];
    }
}