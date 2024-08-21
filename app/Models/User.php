<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
//spatie

use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable implements MustVerifyEmail
{
    use  HasRoles,Notifiable , HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
         'name', 'email', 'password', 'estado','Id_empleado',  'is_temporary_password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
 

    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
    }

        // Relación con el modelo Empleado
        public function empleado()
        {
            return $this->belongsTo(Empleado::class, 'Id_empleado', 'Id_empleado');
        }
    
        // Accesor para obtener el nombre del empleado
        public function getNombreEmpleadoAttribute()
        {
            return $this->empleado && $this->empleado->persona ? $this->empleado->persona->Nombre_persona : 'Empleado no asignado';
        }


    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona', 'Id_persona');
    }

    

    protected $casts = [
        'email_veriufied_at' => 'datetime'
    ];






   
}

  


