<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckHostLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $role = Role::where('name', config('constance.role.host'))->first();
            $user = Auth::user();
            if ($user->role_id == $role->id && $user->status == config('constance.const.user_active')) {
                return $next($request);
            }
            else {
                Auth::logout();

                return redirect()->route('host.getLogin');
            }
        } else {
            return redirect()->route('host.getLogin');
        }
    }
}
