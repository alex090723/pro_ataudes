<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPago extends Model
{
    use HasFactory;

    protected $table = 'historial_de_pagos'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_pago'; // Clave primaria

    public $timestamps = false; // Si no estás utilizando las marcas de tiempo de Laravel

    protected $fillable = [
        'id_plan_pago',
        'fecha_pago',
        'monto_pago',
        'metodo_pago',
        'fecha_creacion',
        'fecha_actualizacion'
    ];
}
