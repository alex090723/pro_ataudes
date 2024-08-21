<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class PermisosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-seguridad|crear-seguridad|editar-seguridad|borrar-seguridad', ['only' => ['index']]);
        $this->middleware('permission:crear-seguridad', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-seguridad', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-seguridad', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            $roles = Role::all();
            $permissions = Permission::all();
            $rolePermissions = []; // Inicializar con un array vacío

            // Si se selecciona un rol
            if ($request->has('role_id')) {
                $role = Role::find($request->role_id);
                $rolePermissions = $role ? $role->permissions->pluck('name')->toArray() : [];
            }

            return view('permisos.index', compact('roles', 'permissions', 'rolePermissions'));
        } catch (Exception $e) {
            Log::error('Error fetching permissions: ' . $e->getMessage());
            return redirect()->route('permisos.index')->with('error', 'Ocurrió un error al obtener los permisos.');
        }
    }

    public function update(Request $request)
    {
        try {
            // Verificamos que se haya pasado el `role_id`
            if (!$request->has('role_id')) {
                return redirect()->back()->withErrors('Debe seleccionar un rol.');
            }

            $role = Role::find($request->role_id);

            // Si no se encuentra el rol
            if (!$role) {
                return redirect()->back()->withErrors('El rol seleccionado no existe.');
            }

            // Sincroniza los permisos seleccionados con el rol
            $role->syncPermissions($request->permissions ?? []);

            return redirect()->route('permisos.index')->with('success', 'Permisos actualizados correctamente.');
        } catch (QueryException $e) {
            Log::error('Database error while updating permissions: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar los permisos.');
        } catch (Exception $e) {
            Log::error('Error updating permissions: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar los permisos.');
        }
    }

    public function getPermissions($roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $permissions = $role->permissions->pluck('name')->toArray();

            return response()->json(['permissions' => $permissions]);
        } catch (ModelNotFoundException $e) {
            Log::error('Role not found: ' . $e->getMessage());
            return response()->json(['error' => 'Rol no encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Error fetching permissions for role: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los permisos.'], 500);
        }
    }
}
