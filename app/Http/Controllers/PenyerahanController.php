<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyerahan\{
    StoreRequest,
    UpdateRequest,
};
use App\Models\Kkj;
use App\Models\Pendeta;
use App\Models\Penyerahan;
use App\Models\Wali;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenyerahanController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRolePenyerahan");
    }
    public function index()
    {
        $datas = Penyerahan::with('anggota_keluarga')->where("status", "done")->paginate(4);

        if(Auth::user()->role->nama == "Admin Penyerahan") $datas = Penyerahan::with('anggota_keluarga')->where("cabang_id", Auth::user()->cabang_id)->where("status", "done")->paginate(4);

        return view("penyerahan.index", compact('datas'));
    }

    public function create()
    {
        $pendetas = Pendeta::where("is_active", "1")->get();
        return view("penyerahan.formCreate", compact("pendetas"));
    }

    public function store(StoreRequest $request)
    {
        try {
            $kkj = Kkj::where('kode', $request->search)->first();
            $data = [
                "cabang_id"  => Auth::uset()->cabang_id,
                "kkj_id" => $kkj->id,
                'anggota_keluarga_id' => $request->id,
                'waktu' => Carbon::parse($request->waktu, 'Asia/Jakarta'),
                'pendeta_id' => $request->pendeta,
                "status" => "waiting"
            ]; 
            if($request->foto){
                $path = Storage::disk('public')->put('penyerahan', $request->foto);
                $data['foto'] = $path;
            }

            $dataPenyerahan = Penyerahan::create($data);

            return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil membuat formulir penyerahan");
        } catch (\Throwable $th) {
            return redirect()->route("penyerahan.index")->with("msg_error", "Gagal membuat formulir penyerahan");
        }
    }

    public function show(Penyerahan $penyerahan)
    {
        // add collection kepala keluarga and pasangan
        $penyerahan->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $penyerahan->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $penyerahan->pasangan = DB::table('walis')->select("*")->where("kkj_id", $penyerahan->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();

        if($penyerahan->status == "done"){
            send_pdf_email($penyerahan, $penyerahan->kkj->email, 'penyerahan');
            return back()->with("msg_success", "Berhasil mengirim formulir ke email");
        } 
        return back()->with("msg_info", "Belum boleh mengirim email");
    }

    public function edit($id)
    {
        $data = Penyerahan::with('kkj', 'anggota_keluarga')->find($id);
        $data->kepala_keluarga = Wali::where('kkj_id', $data->kkj->id)->where('status', 'kepala keluarga')->first();
        $data->pasangan = Wali::where('kkj_id', $data->kkj->id)->where('status', 'pasangan')->first();
        $pendetas = Pendeta::where("is_active", "1")->get();

        return view('penyerahan.formEdit', compact('data', "pendetas"));
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
                $path = Storage::disk('public')->put('penyerahan', $request->foto);
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
        $penyerahan = Penyerahan::find($id);
        if(!$penyerahan) return abort(403, "TIDAK ADA DATA TERSEBUT");

        if(Storage::disk("public")->exists("$penyerahan->foto")){
            Storage::disk("public")->delete("$penyerahan->foto");
        }

        $penyerahan->delete();

        return redirect()->route("penyerahan.index")->with("msg_success", "Berhasil menghapus formulir penyerahan");
    }
}
