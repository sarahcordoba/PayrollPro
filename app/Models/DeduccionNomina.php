<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeduccionNomina extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'deducciones_nomina';

    // Deshabilitar timestamps
    public $timestamps = false;

    // Campos asignables masivamente
    protected $fillable = [
        'nomina_id',
        'deduccion_id',
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
    // Relación con el modelo Nomina
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'nomina_id');
    }

    // Relación con el modelo Deduccion
    public function deduccion()
    {
        return $this->belongsTo(Deduccion::class, 'deduccion_id');
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
            ->where('deduccion_id', $this->deduccion_id);
        return $query;
    }
}
