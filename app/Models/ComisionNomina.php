<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComisionNomina extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'comisiones_nomina';

    // Deshabilitar timestamps
    public $timestamps = false;

    // Campos asignables masivamente
    protected $fillable = [
        'nomina_id',
        'comision_id',
        'esporcentaje',
        'monto',
    ];

    // Indicate the primary key (non-incrementing composite key)
    protected $primaryKey = null;
    public $incrementing = false;

    // Attribute casting
    protected $casts = [
        'esporcentaje' => 'boolean',
        'monto' => 'float',
    ];

    // Relationship with Nomina model
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'nomina_id');
    }

    // Relationship with Comision model
    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    // Override the save method for composite key support
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'array';
    }

    protected function setKeysForSaveQuery($query)
    {
        $query->where('nomina_id', $this->nomina_id)
              ->where('comision_id', $this->comision_id);
        return $query;
    }
}