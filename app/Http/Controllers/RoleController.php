<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\{
    StoreRequest,
    UpdateRequest
};
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $datas = Role::paginate(4);
        return view("roles.index", compact('datas'));  
    }

    public function create()
    {
        return view("roles.form");
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = [
                "nama" => $request->nama
            ];
            $role = Role::create($data);

            return redirect()->route("role.index")->with("msg_success", "Berhasil menambahkan role");
        } catch (\Throwable $th) {
            return redirect()->route("role.index")->with("msg_error", "Gagal menambahkan role");
        }
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        $data = $role;
        return view("roles.form", compact("data"));
    }

    public function update(UpdateRequest $request, Role $role)
    {
        try {
            $data = [
                "nama" => $request->nama
            ];

            $role->update($data);
            return redirect()->route("role.index")->with("msg_success", "Berhasil mengubah role");
        } catch (\Throwable $th) {
            return redirect()->route("role.index")->with("msg_error", "Gagal mengubah role");
        }
    }

    public function destroy(Role $role)
    {
        if (!$role) return abort(403, "Data role tersebut tidak tersedia"); 

        $role->delete();

        return redirect()->route("role.index")->with("msg_success", "Berhasil menghapus role");
    }
}
