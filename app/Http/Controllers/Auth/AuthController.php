<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Hash
};

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function storeLogin(StoreRequest $request)
    {
        try {
            $user = User::where("email", $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)) return redirect()->route('auth.store.login')->with("msg_error", "Email atau password salah");

            Auth::login($user);

            return redirect()->route('dashboard')->with("msg_success", "Berhasil login");
        } catch (\Throwable $th) {
        }
    }
}
