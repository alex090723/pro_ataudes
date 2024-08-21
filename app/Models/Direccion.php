<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'Id_direccion'; // Ajusta según tu esquema de base de datos
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
