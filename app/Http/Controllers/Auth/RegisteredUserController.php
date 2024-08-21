<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\SendTemporaryPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generar una contraseña temporal
        $temporaryPassword = Str::random(10); // Cambié str::random por Str::random


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'is_temporary_password' => true,
        ]);

        

        // Enviar correo al usuario con la contraseña temporal
        Mail::to($user->email)->send(new SendTemporaryPassword($temporaryPassword));

        event(new Registered($user));  // Evento para el registro
        //Auth::login($user);  // Autenticar al usuario

        return redirect()->route('login')->with('message', 'Registro exitoso. Se ha enviado un correo con su contraseña temporal.');
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => [
                    'required',
                    'string',
                    'min:8', // Minimum 8 characters
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[0-9]/', // At least one digit
                    'regex:/[@$!%*#?&]/', // At least one special character
                ],
        ]);
    
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $user->update([
            'password' => Hash::make($request->password),
            'is_temporary_password' => false,
        ]);
    
        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME)->with('message', 'Tu contraseña ha sido cambiada exitosamente.');
    }

}
