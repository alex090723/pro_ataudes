<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
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
            $usuarios = User::with('empleado')->paginate(10);
            $Empleados = DB::table('empleados')
                ->join('persona', 'empleados.Id_persona', '=', 'persona.Id_persona')
                ->where('persona.Tipo_persona', 'Empleado')
                ->select('empleados.Id_empleado', 'persona.Nombre_persona as Nombre_empleado')
                ->get();
           
            $roles = Role::all();
            
            return view('usuarios.index', compact('usuarios', 'Empleados', 'roles'));
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error fetching users: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al obtener los usuarios.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|regex:/^[\pL\s]+$/u|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8', // Minimum 8 characters
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[0-9]/', // At least one digit
                    'regex:/[@$!%*#?&]/', // At least one special character
                ],
                'roles' => 'required',
                'estado' => 'required|string|max:1',
                'Id_empleado' => 'required|integer',
                
            ]);

            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->estado = $request->estado;
            $usuario->Id_empleado = $request->Id_empleado;
            $usuario->assignRole($request->roles);

            $usuario->save();

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (QueryException $e) {
            // Log the exception
            Log::error('Database error while creating user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al crear el usuario.');
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al crear el usuario.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => [
                    'required',
                    'string',
                    'min:8', // Minimum 8 characters
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[0-9]/', // At least one digit
                    'regex:/[@$!%*#?&]/', // At least one special character
                ],
                'estado' => 'required|string|max:1',
                'Id_empleado' => 'required|integer',
              
                'roles' => 'required',
            ]);

            $input = $request->all();

            // Si se proporciona una nueva contraseña, la encriptamos
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, ['password']);
            }

            $usuario = User::findOrFail($id);
            $usuario->update($input);

            // Asignar el rol
            $usuario->syncRoles($request->input('roles'));

            // Actualizar la relación con la persona (empleado)
            $usuario->Id_empleado = $input['Id_empleado'];
            $usuario->save();

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Log the exception
            Log::error('User not found: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        } catch (QueryException $e) {
            // Log the exception
            Log::error('Database error while updating user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al actualizar el usuario.');
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al actualizar el usuario.');
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Log the exception
            Log::error('User not found: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        } catch (QueryException $e) {
            // Log the exception
            Log::error('Database error while deleting user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al eliminar el usuario.');
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al eliminar el usuario.');
        }
    }
}
