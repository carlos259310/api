<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    // Ejemplo de campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad'
    ];


        protected $casts = [
        'precio' => 'decimal:2',
        'cantidad' => 'integer',
    ];

}
