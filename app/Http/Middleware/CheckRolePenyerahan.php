<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRolePenyerahan
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role->nama != "Admin Penyerahan"){
            if(Auth::user()->role->nama == "Super Admin"){
                return $next($request);
            }
            return back()->with("msg_info", "Tidak memiliki akses");
        }
        return $next($request);
    }
}
