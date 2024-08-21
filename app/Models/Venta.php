<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    // El nombre de la tabla en la base de datos
    protected $table = 'ventas';

    // La clave primaria de la tabla
    protected $primaryKey = 'id';

    // Si la clave primaria no es un entero autoincrementable, establece esto en true
    public $incrementing = true;

    // Si la tabla usa timestamps, establece esto en true
    public $timestamps = false;

    // Los atributos que son asignables en masa
    protected $fillable = [
        'id_cliente',
        'id_producto',
        'id_empleado',
        'fecha_venta',
        'cantidad',
        'precio',
        'descuento',
        'isv',
        'descripcion_tipo_venta'
    ];

    // Si deseas que Eloquent convierta los atributos a tipos de datos específicos
    protected $casts = [
        'fecha_venta' => 'date',
        'cantidad' => 'integer',
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'isv' => 'decimal:2',
    ];

    // Definir las relaciones con otros modelos

    /**
     * Obtiene el cliente asociado a la venta.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Obtiene el producto asociado a la venta.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    /**
     * Obtiene el empleado asociado a la venta.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
