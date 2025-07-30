<?php
// app/DTOs/UpdateContribuyenteDTO.php
namespace App\DTOs\Contribuyentes;

class UpdateContribuyenteDTO
{
    public function __construct(
        public readonly ?string $nombres = null,
        public readonly ?string $apellidos = null,

        public readonly ?string $documento = null,
        public readonly ?string $email = null,
        public readonly ?string $telefono = null,
        public readonly ?string $direccion = null,

        public readonly ?int $id_tipo_documento = null,
        public readonly ?string $id_ciudad = null,
        public readonly ?string $id_departamento = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombres: $data['nombres'] ?? null,
            apellidos: $data['apellidos'] ?? null,

            documento: $data['documento'] ?? null,
            email: $data['email'] ?? null,
            telefono: $data['telefono'] ?? null,
            direccion: $data['direccion'] ?? null,

            id_tipo_documento: isset($data['id_tipo_documento']) ? (int) $data['id_tipo_documento'] : null,
            id_ciudad: $data['id_ciudad'] ?? null,
            id_departamento: $data['id_departamento'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'documento' => $this->documento,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'id_tipo_documento' => $this->id_tipo_documento,
            'id_ciudad' => $this->id_ciudad,
            'id_departamento' => $this->id_departamento,
        ], fn($value) => $value !== null);
    }
}
