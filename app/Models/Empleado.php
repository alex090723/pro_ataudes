<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'Id_empleado';

    // Relación con el modelo Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona', 'Id_persona');
    }
}
