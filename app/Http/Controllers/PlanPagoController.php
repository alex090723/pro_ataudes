<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanPagoController extends Controller
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
            // Obtener todos los planes de pago
            $planes = DB::select('CALL SeleccionarPlanPago()');
    
            // Obtener todas las facturas disponibles para el formulario
            $facturas = DB::table('cuenta_por_cobrar')
                ->select('id_cuenta_cobrar', 'numero_factura')
                ->get();
    
        } catch (\Exception $e) {
            Log::error('Error al obtener planes de pago o facturas: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al obtener datos.');
        }
    
        return view('plan_pago.index', compact('planes', 'facturas'));
    }
    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_cuenta_cobrar' => 'required|exists:cuenta_por_cobrar,id_cuenta_cobrar',
            'numero_cuotas' => 'required|integer|min:1',
            'fecha_vencimiento' => 'required|date',
            'monto_abono' => 'required|numeric|min:0',
        ]);

        try {
            // Llamar al procedimiento almacenado para insertar el plan de pago
            DB::statement('CALL InsertarPlanPago(?, ?, ?, ?)', [
                $request->id_cuenta_cobrar,
                $request->numero_cuotas,
                $request->fecha_vencimiento,
                $request->monto_abono,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al insertar plan de pago: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al insertar el plan de pago.');
        }

        return redirect()->route('plan_pago.index')->with('success', 'Plan de pago agregado exitosamente.');
    }
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'numero_cuotas' => 'required|integer|min:1',
            'monto_abono' => 'required|numeric|min:0',
            'fecha_vencimiento_cuotas' => 'required|date',
            'metodo' => 'required|in:Transferencia,Efectivo', // Validar que el método sea uno de los valores permitidos
        ]);
    
        try {
            // Obtener el plan de pago existente
            $planPago = DB::table('plan_pago')
                ->select('saldo_pendiente', 'monto_cuotas', 'numero_cuotas', 'monto_abono')
                ->where('id_plan_pago', $id)
                ->first();
    
            if (!$planPago) {
                return redirect()->back()->withErrors('Plan de pago no encontrado.');
            }
    
            // Ejecutar el procedimiento almacenado
            DB::statement('CALL ActualizarPlanPago(?, ?, ?, ?, ?)', [
                $id,
                $request->numero_cuotas,
                $request->fecha_vencimiento_cuotas,
                $request->monto_abono,
                $request->metodo
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error al actualizar plan de pago: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al actualizar el plan de pago.');
        }
    
        return redirect()->route('plan_pago.index')->with('success', 'Plan de pago actualizado exitosamente.');
    }

}

    


