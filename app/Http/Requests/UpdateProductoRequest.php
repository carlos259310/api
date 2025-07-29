<?php
// app/Http/Requests/UpdateProductoRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productoId = $this->route('producto');
        
        return [
            'nombre' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('productos', 'nombre')->ignore($productoId)
            ],
            'precio' => 'sometimes|numeric|min:0|max:99999999.99',
            'cantidad' => 'sometimes|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe un producto con este nombre',
            'descripcion.string' => 'La descripción debe ser texto',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio no puede ser negativo',
            'cantidad.integer' => 'La cantidad debe ser un número entero',
            'cantidad.min' => 'La cantidad no puede ser negativa',
        ];
    }
}