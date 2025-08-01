<?php

namespace App\DTOs\Productos;

class CreateProductoDTO
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $descripcion,
        public readonly float $precio,
        public readonly int $cantidad,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            descripcion: $data['descripcion'],
            precio: (float) $data['precio'],
            cantidad: (int) $data['cantidad'],
        );
    }

    public function toArray(): array
    {
        return [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
        ];
    }
}
