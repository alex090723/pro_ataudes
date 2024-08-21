<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-venta|crear-venta|editar-venta|borrar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create','store']]);
        $this->middleware('permission:editar-venta', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-venta', ['only' => ['destroy']]);
    }


    public function index()
    {
        try {
            // Obtener todas las ventas utilizando el procedimiento almacenado
            $ventas = DB::select('CALL SeleccionarVentas()');

            // Obtener clientes, empleados y productos
            $clientes = DB::table('persona')
                ->join('clientes', 'persona.id_persona', '=', 'clientes.id_persona')
                ->where('persona.Tipo_persona', 'Cliente')
                ->select('clientes.id_cliente', 'persona.Nombre_persona as nombre_cliente')
                ->get();

            $empleados = DB::table('persona')
                ->join('empleados', 'persona.id_persona', '=', 'empleados.id_persona')
                ->where('persona.Tipo_persona', 'Empleado')
                ->select('empleados.id_empleado', 'persona.Nombre_persona as nombre_empleado')
                ->get();

            $productos = DB::table('producto')
                ->select('id_producto', 'nombre_producto', 'precio')
                ->get();

            return view('ventas.index', compact('ventas', 'clientes', 'empleados', 'productos'));
        } catch (\Exception $e) {
            Log::error('Error al obtener ventas: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al obtener ventas.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_producto' => 'required|exists:producto,id_producto',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'isv' => 'nullable|numeric|min:0',
            'descripcion_tipo_venta' => 'required|string|in:Contado,Credito',
        ]);

        try {
            DB::statement('CALL InsertarVenta(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->id_cliente,
                $request->id_producto,
                $request->id_empleado,
                $request->cantidad,
                $request->precio,
                $request->descuento ?: 0,
                $request->isv ?: 15,
                $request->descripcion_tipo_venta,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al insertar venta: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al agregar la venta.');
        }

        return redirect()->route('ventas.index')->with('success', 'Venta agregada exitosamente.');
    }

    public function edit($id)
    {
        try {
            $venta = DB::table('ventas')->where('id_venta', $id)->first();

            if (!$venta) {
                return response()->json(['error' => 'Venta no encontrada.'], 404);
            }

            $clientes = DB::table('persona')
                ->join('clientes', 'persona.id_persona', '=', 'clientes.id_persona')
                ->where('persona.Tipo_persona', 'Cliente')
                ->select('clientes.id_cliente', 'persona.Nombre_persona as nombre_cliente')
                ->get();

            $empleados = DB::table('persona')
                ->join('empleados', 'persona.id_persona', '=', 'empleados.id_persona')
                ->where('persona.Tipo_persona', 'Empleado')
                ->select('empleados.id_empleado', 'persona.Nombre_persona as nombre_empleado')
                ->get();

            $productos = DB::table('producto')
                ->select('id_producto', 'nombre_producto', 'precio')
                ->get();

            return response()->json([
                'venta' => $venta,
                'clientes' => $clientes,
                'empleados' => $empleados,
                'productos' => $productos
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener venta: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener venta.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_producto' => 'required|exists:producto,id_producto',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'isv' => 'nullable|numeric|min:0',
            'descripcion_tipo_venta' => 'required|string|in:Contado,Credito',
        ]);

        Log::info('Datos de actualización:', $request->all());

        try {
            DB::statement('CALL ActualizarVenta(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->id_cliente,
                $request->id_producto,
                $request->id_empleado,
                $request->cantidad,
                $request->precio,
                $request->descuento ?: 0,
                $request->isv ?: 15,
                $request->descripcion_tipo_venta,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar venta: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al actualizar la venta.');
        }

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }
}
