<?php

namespace App\Http\Controllers;

use App\Http\Requests\Baptis\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Baptis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaptisController extends Controller
{
    public function index()
    {
        $datas = Baptis::with('kkj_anak', 'kkj_keluarga')->paginate(4);
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
        $data = Baptis::with('kkj_anak.kkj_kepala_keluarga', 'kkj_anak.kkj', 'kkj_anak.kkj_pasangan')->find($id);
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
            
            // dd($data);
            $baptis->update($data);

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil mengubah formulir baptis");
        } catch (\Throwable $th) {
            return redirect()->route("baptis.index")->with("msg_error", "Gagal mengubah formulir baptis");
        }
    }

    public function destroy($id)
    {
        $baptis = Baptis::with('kkj_anak')->find($id);
        if(!$baptis) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $baptis->kkj_anak->update(['baptis' => 'T']);
        $baptis->delete();

        return redirect()->route("baptis.index")->with("msg_success", "Berhasil menghapus formulir baptis");
    }
}
