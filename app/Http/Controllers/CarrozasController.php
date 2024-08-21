<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carroza;
use App\Models\Sucursal;

class CarrozasController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-inventario|crear-inventario|editar-inventario|borrar-inventario', ['only' => ['index']]);
        $this->middleware('permission:crear-inventario', ['only' => ['create','store']]);
        $this->middleware('permission:editar-inventario', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-inventario', ['only' => ['destroy']]);
    }




    // Método para mostrar la lista de carrozas
    public function index()
    {
        // Llamar al procedimiento almacenado para obtener todas las carrozas con la información de sucursal
        $carrozas = DB::select('CALL SeleccionarCarrozaFunebres()');
    
        // Obtener todas las sucursales para el formulario de creación/edición
        $sucursales = Sucursal::all();
    
        return view('Carrozas', compact('carrozas', 'sucursales'));
    }
    
    // Método para almacenar una nueva carroza
    public function store(Request $request)
    {
        $request->validate([
            'Id_sucursal' => 'required|integer',
            'placa' => 'required|string|max:50',
            'cantidad_disponible' => 'required|integer',
            'detalle_carroza' => 'nullable|string',
            'precio_carroza' => 'required|numeric',
        ]);

        DB::statement('CALL 	InsertarCarrozaFunebres(?, ?, ?, ?, ?)', [
            $request->Id_sucursal,
            $request->placa,
            $request->cantidad_disponible,
            $request->detalle_carroza,
            $request->precio_carroza,
        ]);

        return redirect()->route('Carrozas.index')->with('success', 'Carroza creada exitosamente.');
    }

    // Método para actualizar una carroza existente
    public function update(Request $request, $id_carroza)
    {
        $request->validate([
            'Id_sucursal' => 'required|integer',
            'placa' => 'required|string|max:50',
            'cantidad_disponible' => 'required|integer',
            'detalle_carroza' => 'nullable|string',
            'precio_carroza' => 'required|numeric',
        ]);

        DB::statement('CALL ActualizarCarrozaFunebres(?, ?, ?, ?, ?, ?)', [
            $id_carroza,
            $request->Id_sucursal,
            $request->placa,
            $request->cantidad_disponible,
            $request->detalle_carroza,
            $request->precio_carroza,
        ]);

        return redirect()->route('Carrozas.index')->with('success', 'Carroza actualizada exitosamente.');
    }
}
