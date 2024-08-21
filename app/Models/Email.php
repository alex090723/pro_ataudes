<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email';
    protected $primaryKey = 'Id_email'; // Ajusta según tu esquema de base de datos
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona');
    }
}
