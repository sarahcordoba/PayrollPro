<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos'; // Nombre de la tabla en singular
    protected $primaryKey = 'idDepartamento'; // Clave primaria

    protected $fillable = ['nombre']; // Campos que se pueden llenar en el modelo

    public $timestamps = false; // Si no tienes campos de timestamps (created_at, updated_at)
}
