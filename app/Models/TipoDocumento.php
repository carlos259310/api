<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class TipoDocumento  extends Model
{
    use HasFactory;

    protected $table = 'tipos_documentos';
    protected $primaryKey = 'id_tipo_documento';
    public $incrementing = true;

    protected $fillable = [
        'documento',
        'codigo'
    ];


    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_tipo_documento', 'id_tipo_documento');
    }
}
