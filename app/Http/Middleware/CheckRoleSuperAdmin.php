<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role_id != 1 || Auth::user()->role->nama != "Super Admin"){
            return back()->with("msg_info", "Tidak memiliki akses");
        }
        return $next($request);
    }
}
