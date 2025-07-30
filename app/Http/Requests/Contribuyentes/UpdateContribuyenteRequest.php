<?php
// app/Http/Requests/CreateContribuyenteRequest.php
namespace App\Http\Requests\Contribuyentes;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ciudad; 
class UpdateContribuyenteRequest  extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
      //  $id = $this->route('contribuyente'); // Obtener el ID del contribuyente de la ruta

        return [
            'nombres' => 'sometimes|string|max:100',
            'apellidos' => 'sometimes|string|max:100',

            //'documento' => "sometimes|string|max:20|unique:contribuyentes,documento,{$id},id_contribuyente",
            //'email' => "sometimes|email|max:150|unique:contribuyentes,email,{$id},id_contribuyente",
            'telefono' => 'sometimes|string|max:20',
            'direccion' => 'sometimes|string|max:200',

            'id_tipo_documento' => 'sometimes|integer|exists:tipos_documentos,id_tipo_documento',
            'id_ciudad' => 'sometimes|string|exists:ciudades,id_ciudad',
            'id_departamento' => 'sometimes|string|exists:departamentos,id_departamento',
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
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Ya existe un contribuyente con este documento',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe tener un formato válido',
            'email.unique' => 'Ya existe un contribuyente con este email',
            'id_tipo_documento.exists' => 'El tipo de documento seleccionado no es válido',
            'id_ciudad.exists' => 'La ciudad seleccionada no es válida',
            'id_departamento.exists' => 'El departamento seleccionado no es válido',
        ];
    }
}
