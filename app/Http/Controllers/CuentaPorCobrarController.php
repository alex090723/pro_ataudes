<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuentaPorCobrarController extends Controller
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
        // Obtener todas las cuentas por cobrar utilizando el procedimiento almacenado
        try {
            $cuentas = DB::select('CALL SeleccionarCuentaPorCobrar()');
        } catch (\Exception $e) {
            Log::error('Error al obtener cuentas por cobrar: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al obtener cuentas por cobrar.');
        }
    
        // Obtener clientes desde la tabla persona
        $clientes = DB::table('persona')
            ->join('clientes', 'persona.id_persona', '=', 'clientes.id_persona')
            ->where('persona.Tipo_persona', 'Cliente')
            ->select('clientes.id_cliente', 'persona.Nombre_persona as nombre_cliente')
            ->get();
    
        // Para depuración, puedes registrar los datos obtenidos
        Log::info('Cuentas obtenidas:', (array) $cuentas);
        Log::info('Clientes obtenidos:', (array) $clientes);
    
        return view('cuentasPorCobrar.index', compact('cuentas', 'clientes'));
    }
    
    public function edit($id)
    {
        // Obtener la cuenta por cobrar a editar
        try {
            $cuenta = DB::select('CALL SeleccionarCuentaPorCobrarPorID(?)', [$id]);
            $cuenta = $cuenta[0]; // `DB::select` devuelve un array de resultados
        } catch (\Exception $e) {
            Log::error('Error al obtener cuenta por cobrar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener cuenta por cobrar.'], 500);
        }
    
        return response()->json([
            'id_cuenta_cobrar' => $cuenta->id_cuenta_cobrar,
            'nombre_cliente' => $cuenta->nombre_cliente,
            'numero_factura' => $cuenta->numero_factura,
            'fecha_factura' => $cuenta->fecha_factura,
            'monto_total' => $cuenta->monto_total,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_cuenta_cobrar' => 'required|exists:cuenta_por_cobrar,id_cuenta_cobrar',
            'numero_factura' => 'required|integer',
            'id_cliente' => 'required|exists:clientes,id_cliente',
        ]);

        try {
            // Llamar al procedimiento almacenado para actualizar la cuenta por cobrar
            $result = DB::select('CALL ActualizarCuentaPorCobrar(?, ?, ?)', [
                $request->id_cuenta_cobrar,
                $request->numero_factura,
                $request->id_cliente,
            ]);

            // Comprobar si se obtuvieron resultados del procedimiento
            if (empty($result)) {
                return redirect()->back()->withErrors('Error al actualizar la cuenta por cobrar.');
            }

            // Para depuración, puedes registrar los datos obtenidos
            Log::info('Cuenta actualizada:', (array) $result[0]);

            return redirect()->route('cuentas.index')->with('success', 'Cuenta por cobrar actualizada exitosamente.')
                ->with('updatedData', $result[0]); // Pasar datos actualizados a la vista

        } catch (\Exception $e) {
            Log::error('Error al actualizar cuenta por cobrar: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al actualizar la cuenta por cobrar.');
        }
    }
}
