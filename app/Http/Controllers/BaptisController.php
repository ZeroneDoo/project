<?php

namespace App\Http\Controllers;

use App\Http\Requests\Baptis\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\AnggotaKeluarga;
use App\Models\Baptis;
use App\Models\Kkj;
use App\Models\Wali;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BaptisController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRoleBaptis");
    }
    public function index()
    {
        $datas = Baptis::with('anggota_keluarga')->where('status', "done")->paginate(4);
        return view("baptis.index", compact('datas'));
    }

    public function create()
    {
        return view("baptis.formCreate");
    }

    public function store(StoreRequest $request)
    {
        try {
            $kkj = Kkj::where('kode', $request->search)->first();
            $data = [
                "kkj_id" => $kkj->id,
                'anggota_keluarga_id' => $request->id,
                'waktu' => Carbon::parse($request->waktu, 'Asia/Jakarta'),
                'pendeta' => $request->pendeta,
                "status" => "waiting"
            ]; 

            if($request->foto){
                $path = Storage::disk('public')->put('baptis', $request->foto);
                $data['foto'] = $path;
            }
            
            $dataBaptis = Baptis::create($data);

            return redirect()->route("baptis.index")->with("msg_success", "Berhasil membuat formulir baptis");
        } catch (\Throwable $th) { 
            return redirect()->route("baptis.index")->with("msg_error", "Gagal membuat formulir baptis");
        }
    }

    public function show($id)
    {
        $baptis = Baptis::find($id);
        
        $baptis->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $baptis->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $baptis->pasangan = DB::table('walis')->select("*")->where("kkj_id", $baptis->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();

        if($baptis->status == "done"){
            send_pdf_email($baptis, $baptis->kkj->email, 'baptis');
            return back()->with("msg_success", "Berhasil mengirim ke email");
        } 
        return back()->with("msg_info", "Belum bisa mengirim email");

    }

    public function edit($id)
    {
        $data = Baptis::with('kkj', 'anggota_keluarga')->find($id);
        $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();
        
        return view("baptis.formEdit", compact("data"));
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
