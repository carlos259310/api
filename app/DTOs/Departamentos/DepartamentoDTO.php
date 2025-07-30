<?php
// app/DTOs/DepartamentoDTO.php
namespace App\DTOs\Departamentos;

class DepartamentoDTO
{
    public function __construct(
        public readonly string $id_departamento,
        public readonly string $departamento,
    ) {}

    public static function fromModel($departamento): self
    {
        return new self(
            id_departamento: $departamento->id_departamento,
            departamento: $departamento->departamento,
        );
    }

    public function toArray(): array
    {
        return [
            'id_departamento' => $this->id_departamento,
            'departamento' => $this->departamento,
        ];
    }
}