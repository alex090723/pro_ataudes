<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CheckTemporaryPassword
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            if ($user->is_temporary_password) {
                return redirect()->route('password.change');
            }
        }
    
        return $next($request);
    }
}
