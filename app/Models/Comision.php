<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'comisiones';

    // Campos asignables masivamente
    protected $fillable = [
        'tipo',
        'descripcion',
        'esporcentaje',
        'monto',
        'obligatorio',
    ];
}
