<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Persona;

class UserController extends Controller
{
    // Método para mostrar la lista de usuarios

    public function index()
    {
        $cont = 1;
        $estatus = 'Sin Estado';
        // Llamar al procedimiento almacenado
        $users = DB::select('CALL GetUsersWithRolesAndPersonas()');

        // Obtener todos los roles para el formulario de creación/edición
        $roles = Role::all();

        // Obtener todas las personas para el formulario de creación/edición
        $personas = Persona::all();        
        

        return view('usuario', compact('users', 'roles', 'cont','personas', 'estatus' ));
        
 
        

    /*
       $cont = 1;
        
        // Obtener todos los usuarios con sus roles
        $users = User::with('rol')->get();
        
        // Transformar la colección para incluir solo el nombre del rol
        $users = $users->map(function($user) {
            $user->rol = $user->rol ? $user->rol->rol : 'Sin rol';
           return $user;
        });

        $roles = Role::all();
        return view('usuario', compact('users', 'roles', 'cont'));

    */


    dd($users);
    }


    
 

    // Método para almacenar un nuevo usuario
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'id_rol' => 'required|integer',
            'Id_persona' => 'required|integer',
            'estado' => 'required|string|max:1',
            'remember_token' => 'nullable|string|max:100',
        ]);

        DB::statement('CALL InsertarUsuario(?, ?, ?, ?, ?, ?, ?)', [
            $request->name,
            $request->email,
            bcrypt($request->password),
            $request->id_rol,
            $request->Id_persona,
            $request->estado,
            $request->remember_token
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Método para actualizar un usuario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'id_rol' => 'required|integer',
            'Id_persona' => 'required|integer',
            'estado' => 'required|string|max:1',
            'remember_token' => 'nullable|string|max:100',
        ]);

        $user = User::findOrFail($id);

        $password = $user->password;
        if ($request->filled('password')) {
            $password = bcrypt($request->password);
        }

        DB::statement('CALL ActualizarUsuario(?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->name,
            $request->email,
            $password,
            $request->id_rol,
            $request->Id_persona,
            $request->estado,
            $request->remember_token
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado exitosamente.');
    }
}
