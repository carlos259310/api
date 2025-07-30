<?php
// app/Http/Requests/CreateContribuyenteRequest.php
namespace App\Http\Requests\Contribuyentes;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ciudad; 
class CreateContribuyenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'nombre_completo' => 'nullable|string|max:120',
            'documento' => 'nullable|string|max:20|unique:contribuyentes,documento',
            'email' => 'required|email|max:100|unique:contribuyentes,email',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'id_tipo_documento' => 'required|integer|exists:tipos_documentos,id_tipo_documento',
            'id_ciudad' => 'required|string|exists:ciudades,id_ciudad',
            'id_departamento' => 'required|string|exists:departamentos,id_departamento',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCiudadDepartamento($validator);
        });
    }
    /**
     * Validar que la ciudad pertenezca al departamento seleccionado
     */
    private function validateCiudadDepartamento($validator)
    {
        $id_ciudad = $this->input('id_ciudad');
        $id_departamento = $this->input('id_departamento');

        // Solo validar si ambos campos están presentes
        if (!$id_ciudad || !$id_departamento) {
            return;
        }

        $ciudadExists = Ciudad::where('id_ciudad', $id_ciudad)
            ->where('id_departamento', $id_departamento)
            ->exists();

        if (!$ciudadExists) {
            $validator->errors()->add(
                'id_ciudad',
                'La ciudad seleccionada no pertenece al departamento especificado.'
            );
        }
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'Los nombres son obligatorios',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'documento.unique' => 'Ya existe un contribuyente con este documento',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe tener un formato válido',
            'email.unique' => 'Ya existe un contribuyente con este email',
            'telefono.required' => 'El teléfono es obligatorio',
            'direccion.required' => 'La dirección es obligatoria',
            'id_tipo_documento.required' => 'El tipo de documento es obligatorio',
            'id_tipo_documento.exists' => 'El tipo de documento seleccionado no es válido',
            'id_ciudad.required' => 'La ciudad es obligatoria',
            'id_ciudad.exists' => 'La ciudad seleccionada no es válida',
            'id_departamento.required' => 'El departamento es obligatorio',
            'id_departamento.exists' => 'El departamento seleccionado no es válido',
        ];
    }
}
