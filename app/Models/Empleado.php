<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Empleado extends Model
{
    use HasFactory;
    use Notifiable;
    public $timestamps = false; // Desactiva timestamps

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_identificacion',
        'numero_identificacion',
        'municipio',
        'direccion',
        'celular',
        'correo',
        'tipo_contrato',
        'fecha_contratacion',
        'fecha_fin_contrato',
        'salario',
        'salario_integral',
        'frecuencia_pago',
        'tipo_trabajador',
        'subtipo_trabajador',
        'auxilio_transporte',
        'alto_riesgo',
        'sabado_laboral',
        'nivel_riesgo',
        'cargo',
        'area',
        'dias_vacaciones',
        'metodo_pago',
        'banco',
        'numero_cuenta',
        'tipo_cuenta',
        'eps',
        'caja_compensacion',
        'fondo_pensiones',
        'fondo_cesantias',
    ];

    public function routeNotificationForMail($notification)
    {
        return $this->correo; // o el campo correcto si no es "correo"
    }
}
