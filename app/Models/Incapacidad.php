<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incapacidad extends Model
{
    use HasFactory;

    protected $table = 'incapacidades'; // Especifica el nombre de la tabla si no es plural de la clase

    public $timestamps = false; // Desactiva timestamps
    protected $fillable = [
        'id_empleado',
        'fecha_inicio',
        'fecha_fin',
        'dias_incapacidad',
        'fecha_registro',
        'tipo_incapacidad',
        'descripcion',
        'soporte',
        'estado',
        'fecha_revision',
        'id_rrhh',
        'observaciones_rrhh'
    ];
}
