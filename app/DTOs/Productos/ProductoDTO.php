<?php

namespace App\Dtos\Productos\Productos;

class ProductoDTO
{

    //constructor por defecto
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $nombre = '',
        public readonly string $descripcion = '',
        public readonly float $precio = 0.0,
        public readonly int $cantidad = 0,
    ) {}


    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? '',
            precio: (float) ($data['precio'] ?? 0),
            cantidad: (int) ($data['cantidad'] ?? 0),
        );
    }

    public static function fromModel($producto): self
    {
        return new self(
            id: $producto->id,
            nombre: $producto->nombre,
            descripcion: $producto->descripcion,
            precio: $producto->precio,
            cantidad: $producto->cantidad,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad
        ];
    }
}
