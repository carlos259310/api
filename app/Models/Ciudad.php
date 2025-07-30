<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    
    protected $table = 'ciudades';
    protected $primaryKey = 'id_ciudad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_ciudad', 'ciudad', 'id_departamento'];

    
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_ciudad', 'id_ciudad');
    }

}
