<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyerahan\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Penyerahan;
use Illuminate\Http\Request;

class PenyerahanController extends Controller
{
    public function index()
    {
        return view("penyerahan.index");
    }

    public function create()
    {
        return view("penyerahan.form");
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = []; 

            return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil membuat formulir penyerahan");
        } catch (\Throwable $th) {
            return redirect()->route("penyerahan.index")->with("msg_error", "Gagal membuat formulir penyerahan");
        }
    }

    public function show(Penyerahan $penyerahan)
    {
        //
    }

    public function edit(Penyerahan $penyerahan)
    {
        $data = $penyerahan;
        return view('penyerahan.form', compact('data'));
    }

    public function update(UpdateRequest $request, Penyerahan $penyerahan)
    {
        try {
            $data = []; 

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil mengubah formulir baptis");
        } catch (\Throwable $th) {
            return redirect()->route("baptis.index")->with("msg_error", "Gagal mengubah formulir baptis");
        }
    }

    public function destroy(Penyerahan $penyerahan)
    {
        if(!$penyerahan) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $penyerahan->delete();

        return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil menghapus formulir penyerahan");
    }
}
