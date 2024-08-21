<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventarioMateriales;
use App\Models\Proveedor;

use Illuminate\Support\Facades\DB;

class InventarioMaterialesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-inventario|crear-inventario|editar-inventario|borrar-inventario', ['only' => ['index']]);
        $this->middleware('permission:crear-inventario', ['only' => ['create','store']]);
        $this->middleware('permission:editar-inventario', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-inventario', ['only' => ['destroy']]);
    }


    public function index() {
        $Materiales = DB::select('CALL MostrarInventarioMateriales()');
        $Proveedores = DB::table('proveedores')
            ->join('persona', 'proveedores.Id_persona', '=', 'persona.Id_persona')
            ->where('persona.Tipo_persona', 'Proveedor')
            ->select('proveedores.Id_proveedor', 'persona.Nombre_persona as Nombre_proveedor')
            ->get();
    
        return view('inventario_materiales', compact('Materiales', 'Proveedores'));
    }

    public function edit($id)
    {
        $material = InventarioMateriales::find($id); // Asegúrate de que el modelo es InventarioMateriales
        $proveedores = Proveedor::all();
        return view('material.edit', compact('material', 'proveedores'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'Id_proveedor' => 'required|integer',
            'tipo_material' => 'required|string|max:255',
            'cantidad_disponible' => 'required|integer',
            'fecha_adquisicion' => 'required|date',
            'precio_unitario' => 'required|numeric',
            'ubicacion' => 'required|string|max:255',
            'estado_material' => 'required|string|max:50',
        ]);

        // Llamar al procedimiento almacenado para insertar un nuevo material
        DB::statement('CALL InsertarInventarioMateriales(?, ?, ?, ?, ?, ?, ?)', [
            $request->Id_proveedor,
            $request->tipo_material,
            $request->cantidad_disponible,
            $request->fecha_adquisicion,
            $request->precio_unitario,
            $request->ubicacion,
            $request->estado_material,
        ]);

        return redirect()->route('Materiales.index')->with('success', 'Material agregado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'Id_proveedor' => 'required|integer',
            'tipo_material' => 'required|string|max:255',
            'cantidad_disponible' => 'required|integer',
            'fecha_adquisicion' => 'required|date',
            'precio_unitario' => 'required|numeric',
            'ubicacion' => 'required|string|max:255',
            'estado_material' => 'required|string|max:50',
        ]);

        // Llamar al procedimiento almacenado para actualizar un material
        DB::statement('CALL ActualizarInventarioMateriales(?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->Id_proveedor,
            $request->tipo_material,
            $request->cantidad_disponible,
            $request->fecha_adquisicion,
            $request->precio_unitario,
            $request->ubicacion,
            $request->estado_material,
        ]);

        return redirect()->route('Materiales.index')->with('success', 'Material actualizado exitosamente.');
    }
}
