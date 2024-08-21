<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ataud;
use App\Models\Sucursal;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-inventario|crear-inventario|editar-inventario|borrar-inventario', ['only' => ['index']]);
        $this->middleware('permission:crear-inventario', ['only' => ['create','store']]);
        $this->middleware('permission:editar-inventario', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-inventario', ['only' => ['destroy']]);
    }


    // Método para mostrar la vista de productos
    public function index()
    {
     
        // Llamar al procedimiento almacenado para obtener ataúdes
        $Productos = DB::select('CALL  SeleccionarProducto()');
    
        // Obtener todas las sucursales para el formulario de creación/edición
        $sucursales = Sucursal::all(); 
    
        return view('Productos', compact('Productos', 'sucursales'));
    }
    // Método para almacenar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'Id_sucursal' => 'required|integer',
            'tipo_producto' => 'required|string|max:255',
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'categoria' => 'required|string|max:255',
            'tamaño' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        // Llamar al procedimiento almacenado para insertar un nuevo producto
        DB::statement('CALL InsertarProducto(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)', [
            $request->Id_sucursal,
            $request->tipo_producto,
            $request->nombre_producto,
            $request->descripcion,
            $request->precio,
            $request->cantidad_disponible,
            $request->categoria,
            $request->tamaño,
            $request->modelo,
            $request->estado,
            now() // Fecha de creación (puedes modificarla según lo necesites)
        ]);

        return redirect()->route('Productos.index')->with('success', 'Producto agregado exitosamente.');
    }

    // Método para actualizar un producto existente
    public function update(Request $request, $id_producto)
    {
        $request->validate([
            'Id_sucursal' => 'required|integer',
            'tipo_producto' => 'required|string|max:255',
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'categoria' => 'required|string|max:255',
            'tamaño' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        // Llamar al procedimiento almacenado para actualizar un producto existente
        DB::statement('CALL ActualizarProducto(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id_producto,
            $request->Id_sucursal,
            $request->tipo_producto,
            $request->nombre_producto,
            $request->descripcion,
            $request->precio,
            $request->cantidad_disponible,
            $request->categoria,
            $request->tamaño,
            $request->modelo,
            $request->estado,
            now() // Fecha de última actualización
        ]);

        return redirect()->route('Productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
}
