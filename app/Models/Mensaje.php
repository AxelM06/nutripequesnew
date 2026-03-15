<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    // Nombre exacto de tu tabla según la imagen
    protected $table = 'contacts';

    // Campos exactos de tu tabla
    protected $fillable = [
        'nombre',
        'correo',
        'Prioridad',
        'mensaje',
        'asunto',
    ];
}