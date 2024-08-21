<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inventarioMateriales;

class Proveedor extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'proveedores';
    
    // Clave primaria de la tabla
    protected $primaryKey = 'Id_proveedor';
    
    // Indica que no se manejan timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos que pueden ser llenados en masa
    protected $fillable = [
        'Nombre_proveedor', // Añadido el campo para el nombre del proveedor
        'Id_persona'       // Campo para la relación con la tabla 'personas'
    ];

    // Relación uno a muchos con el modelo InventarioMateriales
    public function inventarioMateriales()
    {
        return $this->hasMany(InventarioMateriales::class, 'Id_proveedor', 'Id_proveedor');
    }

    // Relación con el modelo Persona (si tienes un modelo para la tabla personas)
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona', 'Id_persona');
    }
}
