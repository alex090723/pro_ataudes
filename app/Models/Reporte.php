<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    // Define el nombre de la tabla si no sigue la convención
    protected $table = 'reportes';

    // Define los campos que son asignables en masa
    protected $fillable = ['Tipo_reportes', 'Detalles_reportes'];
}
