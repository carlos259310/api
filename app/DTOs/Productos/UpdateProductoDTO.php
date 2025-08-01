<?php

namespace App\DTOs\Productos;

class UpdateProductoDTO
{
    public function __construct(
        public readonly ?string $nombre = null,
        public readonly ?string $descripcion = null,
        public readonly ?float $precio = null,
        public readonly ?int $cantidad = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'] ?? null,
            descripcion: $data['descripcion'] ?? null,
            precio: isset($data['precio']) ? (float) $data['precio'] : null,
            cantidad: isset($data['cantidad']) ? (int) $data['cantidad'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
        ], fn($value) => $value !== null);
    }
}
