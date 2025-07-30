<?php
// database/factories/ContribuyenteFactory.php
namespace Database\Factories;

use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContribuyenteFactory extends Factory
{
    public function definition(): array
    {
        $nombres = $this->faker->firstName();
        $apellidos = $this->faker->lastName();
        
        return [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'nombre_completo' => $nombres . ' ' . $apellidos,
            'documento' => $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numerify('3#########'), // Número colombiano de 10 dígitos
            'direccion' => $this->faker->address(),
            'id_tipo_documento' => TipoDocumento::inRandomOrder()->first()?->id ?? 1,
            'id_ciudad' => Ciudad::inRandomOrder()->first()?->id_ciudad ?? '11001',
            'id_departamento' => Departamento::inRandomOrder()->first()?->id_departamento ?? '11',
        ];
    }
}