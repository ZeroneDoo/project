<?php

namespace App\Http\Controllers;

use App\Http\Requests\Baptis\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Baptis;
use Illuminate\Http\Request;

class BaptisController extends Controller
{
    public function index()
    {
        return view("baptis.index");
    }

    public function create()
    {
        return view("baptis.form");
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = []; 

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil membuat formulir baptis");
        } catch (\Throwable $th) {
            return redirect()->route("baptis.index")->with("msg_error", "Gagal membuat formulir baptis");
        }
    }

    public function show(Baptis $baptis)
    {
        //
    }

    public function edit(Baptis $baptis)
    {
        $data = $baptis;
        return view("bapatis.form", compact("data"));
    }

    public function update(UpdateRequest $request, Baptis $baptis)
    {
        try {
            $data = []; 

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil mengubah formulir baptis");
        } catch (\Throwable $th) {
            return redirect()->route("baptis.index")->with("msg_error", "Gagal mengubah formulir baptis");
        }
    }

    public function destroy(Baptis $baptis)
    {
        if(!$baptis) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $baptis->delete();

        return redirect()->route("baptis.index")->with("msg_success", "Berhasil menghapus formulir baptis");
    }
}
