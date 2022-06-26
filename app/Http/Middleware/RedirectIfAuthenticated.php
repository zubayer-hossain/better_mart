<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user_type = $request->input('user_type');
        if ($user_type === "customer") {
            $email = $request->input('email');
            if (!empty($email)) {
                $is_backend_user = User::whereEmail($email)->first();
                if (!empty($is_backend_user) && !empty($is_backend_user->role_id)) {
                    throw ValidationException::withMessages(['message'=>'These credentials do not match our records.']);
                }
            }
        }
        elseif($user_type === "admin"){
            $email = $request->input('email');
            if (!empty($email)) {
                $is_backend_user = User::whereEmail($email)->first();
                if (!empty($is_backend_user) && empty($is_backend_user->role_id)) {
                    throw ValidationException::withMessages(['email'=>'These credentials do not match our records.']);
                }
            }
        }

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
