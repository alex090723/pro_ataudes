<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefono';
    protected $primaryKey = 'Id_telefono'; // Ajusta según tu esquema de base de datos
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona');
    }
}
