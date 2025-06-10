<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'empleado_id',
        'nomina_id',
        'total_devengado',
        'total_deducciones',
        'total_pagado',
        'fecha_pago',
        'estado_pago',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function nomina()
    {
        return $this->belongsTo(Nomina::class);
    }
}
