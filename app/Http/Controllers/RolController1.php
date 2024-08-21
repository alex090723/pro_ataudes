<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function index()
    {
        // Llamada al procedimiento almacenado GetRoles para obtener la lista de roles
        $roles = DB::select('CALL GetRoles()');
        return view('roles', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rol' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        // Llamada al procedimiento almacenado InsertRol para insertar un nuevo rol
        DB::statement('CALL InsertRol(?, ?, ?)', [
            $request->rol,
            $request->descripcion,
            $request->estado,
        ]);

        return redirect()->route('rol.index')->with('success', 'Rol creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        // Llamada al procedimiento almacenado UpdateRol para actualizar un rol existente
        DB::statement('CALL UpdateRol(?, ?, ?, ?)', [
            $id,
            $request->rol,
            $request->descripcion,
            $request->estado,
        ]);

        return redirect()->route('rol.index')->with('success', 'Rol actualizado exitosamente.');
    }
}
