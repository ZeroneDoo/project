<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\{
    Role,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::with('role')->paginate(4);
        return view("admin.index", compact('datas'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.form', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = [
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ];

            User::create($data);
            return redirect()->route('user.index')->with('msg_success', 'Berhasil menambahkan user');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('msg_error', 'Gagal menambahkan user');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = User::with('role')->find($id);
        $roles = Role::all();
        return view('admin.form', compact('data', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $data = [
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ];

            $request->password ? $data['password'] = Hash::make($request->password) : null;

            $user->update($data);

            return redirect()->route('user.index')->with('msg_success', 'Berhasil mengubah user');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('msg_error', 'Gagal mengubah user');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user) return abort(403, 'TIDAK ADA DATA TERSEBUT');

        $user->delete();

        return redirect()->route('user.index')->with('msg_success', 'Berhasil menghapus user');
    }
}
