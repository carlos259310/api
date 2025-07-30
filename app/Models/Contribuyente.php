<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contribuyente extends Model
{
    use HasFactory;

    protected $table = 'contribuyentes';
    protected $primaryKey = 'id_contribuyente';
    public $incrementing = true;

    protected $fillable = [
        'nombres',
        'apellidos',
        'nombre_completo',
        'documento',
        'email',
        'telefono',
        'direccion',
        'id_tipo_documento',
        'id_ciudad',
        'id_departamento'
    ];

    protected $casts = [
        'id_contribuyente' => 'integer',
        'id_tipo_documento' => 'integer',
        'id_ciudad' => 'string',
        'id_departamento' => 'string',
    ];

    /*Relaciones*/


    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento', 'id_tipo_documento');
    }


    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudad', 'id_ciudad');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }


    // Scopes para consultas comunes
    public function scopeActivos($query)
    {
        return $query->whereNotNull('email');
    }

    public function scopePorCiudad($query, $ciudadId)
    {
        return $query->where('id_ciudad', $ciudadId);
    }

    public function scopePorDepartamento($query, $departamentoId)
    {
        return $query->where('id_departamento', $departamentoId);
    }
}
