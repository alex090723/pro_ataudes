<?php
// Modelo 
namespace App\Models;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Producto extends Model
{
    use Notifiable;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'Id_sucursal', 'tipo_producto', 'nombre_producto', 'descripcion', 'Precio', 'cantidad_disponible', 'categoria', 'tamaño', 'modelo', 'estado'
    ];
    public function sucursal1()
    {
        return $this->belongsTo(sucursal::class, 'Id_sucursal', 'Id_sucursal');
    }    

}










