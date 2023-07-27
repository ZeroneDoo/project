<?php

namespace App\Http\Controllers;

use App\Http\Requests\Baptis\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Baptis;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaptisController extends Controller
{
    public function index()
    {
        $datas = Baptis::with('anggota_keluarga')->paginate(4);
        return view("baptis.index", compact('datas'));
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

    public function edit($id)
    {
        $data = Baptis::with('kkj', 'anggota_keluarga')->find($id);
        $data->kepala_keluarga = Wali::where('kkj_id', $data->kkj->id)->where('status', 'kepala keluarga')->first();
        $data->pasangan = Wali::where('kkj_id', $data->kkj->id)->where('status', 'pasangan')->first();
        
        return view("baptis.form", compact("data"));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $baptis = Baptis::find($id);
            
            $data = [
                'waktu' => $request->waktu,
                'pendeta' => $request->pendeta,
            ]; 
            
            if($request->foto){
                $path = Storage::disk('public')->put('baptis', $request->foto);
                $data['foto'] = $path;
                
                if(Storage::disk('public')->exists("$baptis->foto")){
                    Storage::disk('public')->delete("$baptis->foto");
                }
            }
            
            $baptis->update($data);

            $baptis->kepala_keluarga = Wali::where('kkj_id', $baptis->kkj_id)->where('status', 'kepala keluarga')->first();
            $baptis->pasangan = Wali::where('kkj_id', $baptis->kkj_id)->where('status', 'pasangan')->first();

            send_pdf_email($baptis, $baptis->kkj->email, 'baptis');

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil mengubah formulir baptis");
        } catch (\Throwable $th) {
            return redirect()->route("baptis.index")->with("msg_error", "Gagal mengubah formulir baptis");
        }
    }

    public function destroy($id)
    {
        $baptis = Baptis::find($id);
        if(!$baptis) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $baptis->delete();

        return redirect()->route("baptis.index")->with("msg_success", "Berhasil menghapus formulir baptis");
    }
}
