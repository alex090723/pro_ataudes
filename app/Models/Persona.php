<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'Id_persona'; // Nombre de la clave primaria

    protected $fillable = [
        'Nombre_persona',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'Id_persona', 'Nombre_persona');
    }
    public function direccion()
    {
        return $this->hasOne(Direccion::class, 'Id_persona');
    }

    public function email()
    {
        return $this->hasOne(Email::class, 'Id_persona');
    }

    public function telefono()
    {
        return $this->hasOne(Telefono::class, 'Id_persona');
    }

        // Relación inversa con el modelo Empleado
        public function empleado()
        {
            return $this->hasOne(Empleado::class, 'Id_persona', 'Id_persona');
        }

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'Id_persona', 'Id_persona');
    }





    // Otros atributos y métodos del modelo según sea necesario
}
