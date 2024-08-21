<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioMateriales extends Model
{
    use HasFactory;

    protected $table = 'inventario_materiales';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'Id_proveedor');
    }
}

class Proveedor extends Model
{
    use HasFactory;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona');
    }
}


