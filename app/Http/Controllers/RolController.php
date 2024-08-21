<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-seguridad|crear-seguridad|editar-seguridad|borrar-seguridad', ['only' => ['index']]);
        $this->middleware('permission:crear-seguridad', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-seguridad', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-seguridad', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $permissions = Permission::all();
            $roles = Role::all();
            return view('roles.index', compact('roles', 'permissions'));
        } catch (Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al obtener los roles.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name',
                'descripcion' => 'required|string',
                'estado' => 'required|boolean',
            ]);
        
            Role::create([
                'name' => $request->input('name'),
                'descripcion' => $request->input('descripcion'),
                'estado' => $request->input('estado'),
            ]);
        
            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
        } catch (QueryException $e) {
            Log::error('Database error while creating role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al crear el rol.');
        } catch (Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al crear el rol.');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name,' . $id,
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|boolean',
            ]);

            $role = Role::findOrFail($id);
            
            // Actualizar campos 'descripcion' y 'estado' si están presentes
            if ($request->has('descripcion')) {
                $role->descripcion = $request->input('descripcion');
            }
            if ($request->has('estado')) {
                $role->estado = $request->input('estado');
            }

            $role->name = $request->input('name');
            $role->save();

            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Role not found: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
        } catch (QueryException $e) {
            Log::error('Database error while updating role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al actualizar el rol.');
        } catch (Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al actualizar el rol.');
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Role not found: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
        } catch (QueryException $e) {
            Log::error('Database error while deleting role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al eliminar el rol.');
        } catch (Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Ocurrió un error al eliminar el rol.');
        }
    }
}
