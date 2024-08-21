<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HistorialPagosController extends Controller
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
            // Obtener todos los historiales de pagos utilizando el procedimiento almacenado
            $historialDePagos = DB::select('CALL SeleccionarHistorialPagos()');
        } catch (\Exception $e) {
            Log::error('Error al obtener historiales de pagos: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al obtener historiales de pagos.');
        }

        return view('historial_pagos.index', compact('historialDePagos'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_plan_pago' => 'required|exists:plan_pago,id_plan_pago',
            'fecha_pago' => 'required|date',
            'monto_pago' => 'required|numeric|min:0',
            'forma' => 'required|in:Transferencia,Efectivo', // Validar el nuevo campo `forma`
        ]);

        try {
            // Llamar al procedimiento almacenado para insertar un historial de pago
            DB::statement('CALL InsertarHistorialDePagos(?, ?, ?, ?)', [
                $request->id_plan_pago,
                $request->fecha_pago,
                $request->monto_pago, // Asegúrate de incluir el monto en el procedimiento almacenado
                $request->forma,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al insertar historial de pago: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al agregar el historial de pago.');
        }

        return redirect()->route('historial_pagos.index')->with('success', 'Historial de pago agregado exitosamente.');
    }

    public function edit($id)
    {
        try {
            // Obtener el historial de pago específico para editar
            $historialDePago = DB::select('CALL SeleccionarHistorialPagos()', [$id]);

            if (empty($historialDePago)) {
                return redirect()->route('historial_pagos.index')->withErrors('Historial de pago no encontrado.');
            }

            $historialDePago = $historialDePago[0]; // Obtener el primer (y único) resultado

        } catch (\Exception $e) {
            Log::error('Error al obtener historial de pago: ' . $e->getMessage());
            return redirect()->route('historial_pagos.index')->withErrors('Historial de pago no encontrado.');
        }

        return response()->json($historialDePago);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_pago' => 'required|exists:historial_de_pagos,id_pago', // Validar el ID del historial de pago
            'fecha_pago' => 'required|date',
            'monto_pago' => 'required|numeric',
            'forma' => 'required|string|max:15', // Nuevo campo
        ]);
    
        // Depuración: Verifica los datos enviados
        Log::info('Datos de actualización:', [
            'id' => $id,
            'fecha_pago' => $request->fecha_pago,
            'monto_pago' => $request->monto_pago,
            'forma' => $request->forma, // Nuevo campo
        ]);
    
        try {
            // Llamar al procedimiento almacenado para actualizar un historial de pago
            DB::statement('CALL ActualizarHistorialDePagos(?, ?, ?, ?)', [
                $id, // ID del historial de pago
                $request->fecha_pago,
                $request->monto_pago,
                $request->forma, // Nuevo campo
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar historial de pago: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al actualizar el historial de pago.');
        }
    
        return redirect()->route('historial_pagos.index')->with('success', 'Historial de pago actualizado exitosamente.');
    }
  
    public function buscarPorNombre(Request $request)
    {
        // Validar el input del formulario
        $request->validate([
            'nombre_persona' => 'required|string'
        ]);

        $nombrePersona = $request->input('nombre_persona');

        try {
            // Obtener el historial de pagos para el nombre de persona proporcionado
            $historialDePagos = DB::table('historial_de_pagos as hp')
                ->join('plan_pago as pp', 'hp.id_plan_pago', '=', 'pp.id_plan_pago')
                ->join('cuenta_por_cobrar as cc', 'pp.id_cuenta_cobrar', '=', 'cc.id_cuenta_cobrar')
                ->join('clientes as c', 'cc.Id_cliente', '=', 'c.Id_cliente')
                ->join('persona as p', 'c.Id_persona', '=', 'p.Id_persona')
                ->select('hp.id_pago', 'hp.fecha_pago', 'hp.monto_pago', 'hp.forma', 'p.nombre_persona')
                ->where('p.nombre_persona', 'LIKE', '%' . $nombrePersona . '%')
                ->get();

            // Verificar si se encontraron resultados
            if ($historialDePagos->isEmpty()) {
                return redirect()->back()->withErrors('No se encontraron pagos para el nombre proporcionado.');
            }

            // Retornar la vista con los datos para impresión
            return view('historial_pagos.index', compact('historialDePagos'));

        } catch (\Exception $e) {
            Log::error('Error al buscar historial de pagos: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al buscar el historial de pagos.');
        }
    }

  
    public function imprimirHistorial(Request $request)
    {
        $nombrePersona = $request->input('nombre_persona');

        try {
            // Obtener el historial de pagos para la persona especificada
            $historialDePagos = DB::table('historial_de_pagos as hp')
                ->join('plan_pago as pp', 'hp.id_plan_pago', '=', 'pp.id_plan_pago')
                ->join('cuenta_por_cobrar as cc', 'pp.id_cuenta_cobrar', '=', 'cc.id_cuenta_cobrar')
                ->join('clientes as c', 'cc.Id_cliente', '=', 'c.Id_cliente')
                ->join('persona as p', 'c.Id_persona', '=', 'p.Id_persona')
                ->where('p.nombre_persona', $nombrePersona)
                ->select('hp.id_pago', 'hp.fecha_pago', 'hp.monto_pago', 'hp.forma', 'p.nombre_persona')
                ->get();

            if ($historialDePagos->isEmpty()) {
                return redirect()->back()->withErrors('No se encontraron pagos para el cliente especificado.');
            }

            return view('historial_pagos.imprimir', compact('historialDePagos', 'nombrePersona'));

        } catch (\Exception $e) {
            Log::error('Error al imprimir historial de pagos: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al obtener los datos para impresión.');
        }
    }
}