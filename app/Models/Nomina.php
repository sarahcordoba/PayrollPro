<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'nominas';
    public $timestamps = false; // Desactiva timestamps

    // Campos asignables masivamente
    protected $fillable = [
        'empleado_id',
        'idLiquidacion',
        'metodopago',
        'estado',
        'salario_base',
        'total_deducciones',
        'total_comisiones',
        'total',
    ];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Relación con el modelo Liquidacion
    public function liquidacion()
    {
        return $this->belongsTo(Liquidacion::class, 'idLiquidacion');
    }
}
