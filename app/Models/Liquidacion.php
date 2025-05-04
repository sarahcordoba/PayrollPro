<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si coincide con el nombre en plural del modelo)
    protected $table = 'liquidaciones';
    public $timestamps = false; // Desactiva timestamps

    // Definir los campos asignables masivamente
    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'salario',
        'total_deducciones',
        'total_comisiones',
        'total',
    ];
}
