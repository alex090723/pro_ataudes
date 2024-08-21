<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\User;


class ReportesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-reporte|crear-reporte|editar-reporte', ['only' => ['index']]);
        $this->middleware('permission:crear-reporte', ['only' => ['create','store']]);
        $this->middleware('permission:editar-reporte', ['only' => ['edit','update']]);
        
    }

     // app/Http/Controllers/ReportController.php
     public function index()
     {
         return view('reporte.reporte');
     }

     public function generarReporte(Request $request)
     {
         $pantalla = $request->input('pantalla');
         $periodo = $request->input('periodo');
         $datos = $this->obtenerDatosReporte($pantalla, $periodo);
     
         // Generar el PDF y obtener el contenido en una cadena
         $pdf = Pdf::loadView('reporte.pdf', compact('datos', 'pantalla', 'periodo'))->output();
     
         // Codificar en base64
         $pdfBase64 = base64_encode($pdf); // Aquí es donde codificas el contenido del PDF
     
         return view('reporte.mostrar', compact('pdfBase64', 'pantalla', 'periodo'));
     }
     
     private function obtenerDatosReporte($pantalla, $periodo)
     {
        $fechaInicio = $this->calcularFecha($periodo);
        Log::info('Fecha de inicio antes de parsear:', ['fechaInicio' => $fechaInicio]);
        $fechaInicio = \Carbon\Carbon::parse($fechaInicio)->timezone('UTC')->startOfDay();
        Log::info('Fecha de inicio después de parsear y ajustar al inicio del día:', ['fechaInicio' => $fechaInicio]);

         switch ($pantalla) {
             case 'persona':
                 $resultados = DB::select('CALL SELECTPersonas()');
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaRegistro = \Carbon\Carbon::parse($item->Fecha_registro);
                     return $fechaRegistro >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para persona:', ['filtered' => $filtered]);
                 return $filtered;
                 
     
             case 'ventas':
                $resultados = DB::select('CALL SeleccionarVentas()');
                Log::info('Fechas de ventas obtenidas:', ['resultados' => $resultados]);
                
                $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                    $fechaVenta = \Carbon\Carbon::parse($item->fecha_venta);
                    Log::info('Comparación de fechas:', [
                        'fechaInicio' => $fechaInicio->toDateTimeString(),
                        'fechaVenta' => $fechaVenta->toDateTimeString(),
                    ]);
                    return $fechaVenta >= $fechaInicio;
                });
                
                Log::info('Datos filtrados para ventas:', ['filtered' => $filtered]);
                return $filtered;
                
     
             case 'cuenta_por_cobrar':
                 $resultados = DB::select('CALL SeleccionarCuentaPorCobrar()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaFactura = \Carbon\Carbon::parse($item->fecha_factura);
                     return $fechaFactura >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para cuenta_por_cobrar:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'plan_de_pago':
                 $resultados = DB::select('CALL SeleccionarPlanPago()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaVencimiento = \Carbon\Carbon::parse($item->fecha_vencimiento_cuotas);
                     return $fechaVencimiento >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para plan_de_pago:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'historial_de_pagos':
                 $resultados = DB::select('CALL SeleccionarHistorialPagos()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaPago = \Carbon\Carbon::parse($item->fecha_pago);
                     return $fechaPago >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para historial_de_pagos:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'inventario_materiales':
                 $resultados = DB::select('CALL MostrarInventarioMateriales()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaAdquisicion = \Carbon\Carbon::parse($item->Fecha_Adquisicion);
                     return $fechaAdquisicion >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para inventario_materiales:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'carrozas_funebres':
                 $resultados = DB::select('CALL SeleccionarCarrozaFunebres()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaEntrada = \Carbon\Carbon::parse($item->fecha_entrada);
                     return $fechaEntrada >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para carrozas_funebres:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'productos':
                 $resultados = DB::select('CALL SeleccionarProducto()'); // Sin parámetros
                 $filtered = collect($resultados)->filter(function ($item) use ($fechaInicio) {
                     $fechaCreacion = \Carbon\Carbon::parse($item->created_at);
                     return $fechaCreacion >= $fechaInicio;
                 });
                 Log::info('Datos filtrados para productos:', ['filtered' => $filtered]);
                 return $filtered;
     
             case 'users':
                 return User::where('created_at', '>=', $fechaInicio)->get();
     
             default:
                 return collect(); // Retorna una colección vacía si no se encuentra la pantalla
         }
     }
     
     
    
    private function calcularFecha($periodo)
    {
        switch ($periodo) {
            case 'dia':
                return now()->startOfDay();
            case 'semana':
                return now()->startOfWeek();
            case 'mes':
                return now()->startOfMonth();
            case 'Todos los registros':
                // Devolver una fecha que cubra todos los registros o manejar como desees
                return '1900-01-01'; // Ejemplo de fecha antigua
            default:
                return now(); // Considera también manejar un caso por defecto si el periodo es inesperado
        }
    }
}