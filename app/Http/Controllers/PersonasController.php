<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Persona;

class PersonasController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-persona|crear-persona|editar-persona', ['only' => ['index']]);
        $this->middleware('permission:crear-persona', ['only' => ['create','store']]);
        $this->middleware('permission:editar-persona', ['only' => ['edit','update']]);
        
    }

    public function index()
{
    try {
        // Llamar al procedimiento almacenado para obtener los detalles de las personas
        $personas = DB::select('CALL SELECTPersonas()');

        return view('personas.index', ['personas' => $personas]);
    } catch (\Exception $e) {
        Log::error('Error al obtener las personas: ' . $e->getMessage());
        return redirect('/')->with('error', 'Error al obtener las personas');
    }
}


    

public function store(Request $request)
{
    $validatedData = $request->validate([
        'Nombre_persona' => 'required|string|max:255',
        'DNI_persona' => 'required|string|max:20',
        'Sexo_persona' => 'required|string|max:1',
        'Edad_persona' => 'required|integer',
        'Estado_Civil' => 'required|string|max:10',
        'Tipo_persona' => 'required|string|max:20',
        'Pais' => 'required|string|max:50',
        'Departamento' => 'required|string|max:50',
        'Municipio' => 'required|string|max:50',
        'Colonia' => 'required|string|max:50',
        'Email' => 'required|string|email|max:100',
        'Numero_telefono' => 'required|string|max:15',
        'Tipo_telefono' => 'required|string|max:20',
        'Cargo' => 'nullable|string|max:50',
        'Fecha_contratacion' => 'nullable|date',
        'Detalle_material' => 'nullable|string|max:100',
        'Fecha_compra' => 'nullable|date',
    ]);

    try {
        DB::beginTransaction();

        $params = [
            $validatedData['Nombre_persona'],
            $validatedData['DNI_persona'],
            $validatedData['Sexo_persona'],
            $validatedData['Edad_persona'],
            $validatedData['Estado_Civil'],
            $validatedData['Tipo_persona'],
            auth()->user()->name, // Nombre del usuario autenticado
            now(),
            $validatedData['Pais'],
            $validatedData['Departamento'],
            $validatedData['Municipio'],
            $validatedData['Colonia'],
            $validatedData['Email'],
            $validatedData['Numero_telefono'],
            $validatedData['Tipo_telefono'],
            $validatedData['Cargo'] ?? null,
            $validatedData['Fecha_contratacion'] ?? null,
            $validatedData['Detalle_material'] ?? null,
            $validatedData['Fecha_compra'] ?? null,
        ];

        // Registro de los parámetros para depuración
        Log::info('Params for INSERTPersona: ' . json_encode($params));

        DB::select('CALL INSERTPersona(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $params);

        DB::commit();

        return redirect()->route('personas.index')->with('success', 'Persona agregada correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al agregar persona: ' . $e->getMessage());
        return redirect()->route('personas.index')->with('error', 'Error al agregar persona.');
    }
}

public function update(Request $request, $id)
{
    // Valida los datos del formulario
    $validatedData = $request->validate([
        'Nombre_persona' => 'nullable|string|max:255',
        'DNI_persona' => 'nullable|string|max:16',
        'Sexo_persona' => 'nullable|in:M,F',
        'Edad_persona' => 'nullable|integer',
        'Estado_Civil' => 'nullable|in:SOLTERO,CASADO,DIVORCIADO,VIUDO',
        'Tipo_persona' => 'nullable|in:Cliente,Empleado,Proveedor',
        'Pais' => 'nullable|string|max:255',
        'Departamento' => 'nullable|string|max:255',
        'Municipio' => 'nullable|string|max:255',
        'Colonia' => 'nullable|string|max:255',
        'Email' => 'nullable|email|max:255',
        'Numero_Telefono' => 'nullable|string|max:20',
        'Tipo_Telefono' => 'nullable|in:Personal,Casa,Trabajo',
        'Cargo' => 'nullable|string|max:255',
        'Fecha_contratacion' => 'nullable|date',
        'Detalle_material' => 'nullable|string|max:255',
        'Fecha_compra' => 'nullable|date',
    ]);

    // Llama al procedimiento almacenado
    DB::statement('CALL UPDATEPersonas(
        :id, :Nombre_persona, :DNI_persona, :Sexo_persona, :Edad_persona,
        :Estado_Civil, :Tipo_persona, :Usuario_registro, :Fecha_registro,
        :Pais, :Departamento, :Municipio, :Colonia, :Email,
        :Numero_Telefono, :Tipo_Telefono, :Cargo, :Fecha_contratacion,
        :Detalle_material, :Fecha_compra
    )', [
        'id' => $id,
        'Nombre_persona' => $request->input('Nombre_persona'),
        'DNI_persona' => $request->input('DNI_persona'),
        'Sexo_persona' => $request->input('Sexo_persona'),
        'Edad_persona' => $request->input('Edad_persona'),
        'Estado_Civil' => $request->input('Estado_Civil'),
        'Tipo_persona' => $request->input('Tipo_persona'),
        'Usuario_registro' => auth()->user()->name,
        'Fecha_registro' => now()->toDateString(),
        'Pais' => $request->input('Pais'),
        'Departamento' => $request->input('Departamento'),
        'Municipio' => $request->input('Municipio'),
        'Colonia' => $request->input('Colonia'),
        'Email' => $request->input('Email'),
        'Numero_Telefono' => $request->input('Numero_Telefono'),
        'Tipo_Telefono' => $request->input('Tipo_Telefono'),
        'Cargo' => $request->input('Cargo'),
        'Fecha_contratacion' => $request->input('Fecha_contratacion'),
        'Detalle_material' => $request->input('Detalle_material'),
        'Fecha_compra' => $request->input('Fecha_compra'),
    ]);

    return redirect()->route('personas.index')->with('success', 'Persona actualizada exitosamente.');
}
    

public function edit($id)
{
    $persona = Persona::with(['direcciones', 'email', 'telefono', 'empleados', 'proveedores', 'clientes'])
        ->findOrFail($id);

    return view('personas.edit', [
        'persona' => $persona,
    ]);
}

}
