<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';
    protected $primaryKey = 'Id_sucursal';
    protected $fillable = ['Nombre_sucursal'];

    public $timestamps = false; 

    public function ataud1()
    {
        return $this->hasMany(ataud::class, 'Id_sucursal', 'Nombre_sucursal');
    }
}
