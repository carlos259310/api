<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    
    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_departamento', 'departamento'];

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'id_departamento', 'id_departamento');
    }

    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_departamento', 'id_departamento');
    }
}
