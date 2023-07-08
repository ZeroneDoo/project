<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyerahan\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Penyerahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyerahanController extends Controller
{
    public function index()
    {
        $datas = Penyerahan::with('kkj_anak', 'kkj_keluarga')->paginate(4);
        return view("penyerahan.index", compact('datas'));
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

    public function edit($id)
    {
        $data = Penyerahan::with('kkj_anak.kkj', 'kkj_anak.kkj_kepala_keluarga', 'kkj_anak.kkj_pasangan')->find($id);
        return view('penyerahan.form', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $penyerahan = Penyerahan::find($id);
            $data = [
                'waktu' => $request->waktu,
                'pendeta' => $request->pendeta,
            ]; 

            if($request->foto){
                $path = Storage::disk('public')->put('baptis', $request->foto);
                $data['foto'] = $path;

                if(Storage::disk('public')->exists("$penyerahan->foto")){
                    Storage::disk('public')->delete("$penyerahan->foto");
                }
            }

            $penyerahan->update($data);

            return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil mengubah formulir penyerahan");
        } catch (\Throwable $th) {
            return redirect()->route("penyerahan.index")->with("msg_error", "Gagal mengubah formulir penyerahan");
        }
    }

    public function destroy($id)
    {
        $penyerahan = Penyerahan::with('kkj_anak')->find($id);
        if(!$penyerahan) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $penyerahan->kkj_anak->update(['diserahkan' => 'T']);
        $penyerahan->delete();

        return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil menghapus formulir penyerahan");
    }
}
