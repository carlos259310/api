<?php
// app/Http/Requests/CreateProductoRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'string|max:1000',
            'precio' => 'required|numeric|min:0|max:99999999.99',
            'cantidad' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'Ya existe un producto con este nombre',
            'descripcion.string' => 'La descripción debe ser texto',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio no puede ser negativo',
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.integer' => 'La cantidad debe ser un número entero',
            'cantidad.min' => 'La cantidad no puede ser negativa',
        ];
    }
}
