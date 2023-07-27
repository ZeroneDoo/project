<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyerahan\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Penyerahan;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyerahanController extends Controller
{
    public function index()
    {
        $datas = Penyerahan::with('anggota_keluarga')->paginate(4);
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
        $data = Penyerahan::with('kkj', 'anggota_keluarga')->find($id);
        $data->kepala_keluarga = Wali::where('kkj_id', $data->kkj->id)->where('status', 'kepala keluarga')->first();
        $data->pasangan = Wali::where('kkj_id', $data->kkj->id)->where('status', 'pasangan')->first();

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
            
            $penyerahan->kepala_keluarga = Wali::where('kkj_id', $penyerahan->kkj_id)->where('status', 'kepala keluarga')->first();
            $penyerahan->pasangan = Wali::where('kkj_id', $penyerahan->kkj_id)->where('status', 'pasangan')->first();

            send_pdf_email($penyerahan, $penyerahan->kkj->email, 'penyerahan');

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
