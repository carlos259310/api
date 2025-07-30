<?php

namespace App\DTOs\Contribuyentes;

class CreateContribuyenteDTO
{
    public function __construct(
        public readonly string $nombres,
        public readonly string $apellidos,

        public readonly string $documento,
        public readonly string $email,
        public readonly string $telefono,
        public readonly string $direccion,

        public readonly int $id_tipo_documento,
        public readonly string $id_ciudad,
        public readonly string $id_departamento,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombres: $data['nombres'],
            apellidos: $data['apellidos'],
            documento: $data['documento'],
            email: $data['email'],
            telefono: $data['telefono'],
            direccion: $data['direccion'],
            id_tipo_documento: (int) $data['id_tipo_documento'],
            id_ciudad: $data['id_ciudad'],
            id_departamento: $data['id_departamento']
        );
    }

    public function toArray(): array
    {
        return [
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'documento' => $this->documento,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'id_tipo_documento' => $this->id_tipo_documento,
            'id_ciudad' => $this->id_ciudad,
            'id_departamento' => $this->id_departamento,
        ];
    }
}
