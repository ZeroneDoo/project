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
            return back()->with("msg_info", "Tidak memiliki akses");
        }
        return $next($request);
    }
}
