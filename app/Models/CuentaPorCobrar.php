<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    use HasFactory;

    // Definir la tabla asociada al modelo
    protected $table = 'cuentas_por_cobrar';

    // Definir los atributos que son asignables en masa
    protected $fillable = [
        'id_cliente',
        'numero_factura',
        'fecha_factura',
        'monto_total',
    ];

    // Definir los atributos que deben ser convertidos a tipos nativos
    protected $casts = [
        'fecha_factura' => 'date',
    ];

    // Definir la relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Puedes agregar más funciones según tus necesidades, como scopes o métodos adicionales
}
