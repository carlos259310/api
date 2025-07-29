<?php
// database/factories/ProductoFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->paragraph(),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'cantidad' => $this->faker->numberBetween(0, 100),
        ];
    }
}
