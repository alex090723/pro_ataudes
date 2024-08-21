<?php

namespace App\Models;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class carroza extends Model
{

    use Notifiable;

    protected $table = 'carrozas_funebres';
    protected $primaryKey = 'id_carroza';
  

    protected $fillable = [
        'Id_sucursal', 'placa', 'cantidad_diponible', 'fecha_entrada', 'detalle_carroza', 'precio_carroza'
    ];

    public function sucursal1()
    {
        return $this->belongsTo(sucursal::class, 'Id_sucursal', 'Id_sucursal');
    }    



}
