<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjetoController extends Controller
{
    public function index()
    {
        // Llamada al procedimiento almacenado GetObjetos para obtener la lista de objetos
        $objetos = DB::select('CALL GetObjetos()');
        return view('objetos', ['objetos' => $objetos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'objeto' => 'required|string|max:255',
            'tipo_objeto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        // Llamada al procedimiento almacenado InsertObjeto para insertar un nuevo objeto
        DB::statement('CALL InsertObjeto(?, ?, ?, ?)', [
            $request->objeto,
            $request->tipo_objeto,
            $request->descripcion,
            $request->estado,
        ]);

        return redirect()->route('objeto.index')->with('success', 'Objeto creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'objeto' => 'required|string|max:255',
            'tipo_objeto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        // Llamada al procedimiento almacenado UpdateObjeto para actualizar un objeto existente
        DB::statement('CALL UpdateObjeto(?, ?, ?, ?, ?)', [
            $id,
            $request->objeto,
            $request->tipo_objeto,
            $request->descripcion,
            $request->estado,
        ]);

        return redirect()->route('objeto.index')->with('success', 'Objeto actualizado exitosamente.');
    }
}
