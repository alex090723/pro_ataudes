<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanPago extends Model
{
    // La tabla asociada al modelo
    protected $table = 'plan_pago';

    // La clave primaria de la tabla
    protected $primaryKey = 'id_plan_pago';

    // Indica si la clave primaria es un incremento automático
    public $incrementing = true;

    // El tipo de la clave primaria
    protected $keyType = 'int';

    // Indica si el modelo debe manejar las marcas de tiempo
    public $timestamps = false;

    // Los atributos que son asignables en masa
    protected $fillable = [
        'id_cuenta_cobrar',
        'numero_cuotas',
        'monto_cuotas',
        'fecha_vencimiento_cuotas',
        'estatus',
        'fecha_creacion',
        'fecha_modificacion',
        'monto_abono',       // Nuevo campo añadido
        'metodo',            // Nuevo campo añadido
    ];

    // Los atributos que deben ser mutados a tipos de datos nativos
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_vencimiento_cuotas' => 'datetime',
        'metodo' => 'string', // Cast enum to string
    ];

    // Validación de los valores del campo metodo
    public function setMetodoAttribute($value)
    {
        $validValues = ['Transferencia', 'Efectivo'];

        if (in_array($value, $validValues)) {
            $this->attributes['metodo'] = $value;
        } else {
            throw new \InvalidArgumentException("Invalid value for 'metodo': $value");
        }
    }
}
