<?php

namespace App\Http\Controllers;

use App\Models\InventarioMateriales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Reporte; // Importa el modelo Reporte
use App\Models\Venta; // Importa el modelo Venta
use App\Models\Persona; // Importa el modelo Persona
use App\Models\Carroza; // Importa el modelo Persona
use App\Models\Producto; // Importa el modelo Persona
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Realiza una solicitud HTTP GET y devuelve el conteo de elementos.
     *
     * @param string $url
     * @return int
     */
    private function getCountFromEndpoint($url)
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                return count($data);
            } else {
                Log::error("Error en la solicitud a $url: " . $response->body());
                return 0;
            }
        } catch (\Exception $e) {
            Log::error("Excepción en la solicitud a $url: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Muestra el panel de control.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Ejemplo para obtener el número de personas desde la base de datos
    $numeroReportes = Reporte::count(); // Reemplaza Reporte con el modelo y la tabla correctos
    $numeroVentas = Venta::count(); // Reemplaza Venta con el modelo y la tabla correctos
    $numeroPersonas = Persona::count(); // Reemplaza Persona con el modelo y la tabla correctos
    $numeroInventarioMateriales = InventarioMateriales::count(); 
    $numeroCarrozas = Carroza::count(); 
    $numeroProductos = Producto::count(); 
    return view('home', compact('numeroReportes', 'numeroVentas', 'numeroPersonas', 'numeroInventarioMateriales', 'numeroCarrozas', 'numeroProductos'));
}

}
