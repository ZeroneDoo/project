<?php

namespace App\Http\Controllers;

use App\Http\Requests\KKJ\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{
    AnggotaKeluarga,
    Kkj,
    KkjAnak,
    KkjKeluarga,
    KkjKepalaKeluarga,
    KkjPasangan,
    Wali
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KkjController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRoleKartuKeluarga");
    }
    public function index()
    {
        $datas = Kkj::where("status", "done")->paginate(4);

        return view("kkj.index", compact('datas'));
    }

    public function create()
    {
        $status_menikah = ["Sudah Menikah", "Belum Menikah", "Cerai"];
        $jenjangs = ['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', "D3", 'S1', 'S2', "S3"];
        $hubungans = ["Ayah", "Ibu", "Kakak", "Adik", "Suami", "Istri", "Keponakan", "Sepupu"];
        return view("kkj.form", compact("status_menikah", 'jenjangs', 'hubungans'));
    }

    public function store(StoreRequest $request)
    {
        // try {
            $kkj = kartu_keluarga_jemaat($request->all());
            
            return redirect()->route("kkj.index")->with("msg_success", "Berhasil menambahkan kartu keluarga jemaat");
        // } catch (\Throwable $th) {
        //     return redirect()->route("kkj.index")->with("msg_error", "Gagal menambahkan kartu keluarga jemaat");
        // }
    }

    public function show(Kkj $kkj)
    {
        $pasangan = DB::select("SELECT * from walis where kkj_id = $kkj->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $anaks = DB::select("SELECT * from anggota_keluargas where kkj_id = $kkj->id and hubungan = 'anak' and deleted_at IS NULL");
        $keluargas = DB::select("SELECT * from anggota_keluargas where kkj_id = $kkj->id and hubungan <> 'anak' and deleted_at IS NULL");
        
        $kkj->kepala_keluarga = DB::select("SELECT * from walis where kkj_id = $kkj->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $kkj->pasangan = $pasangan ? $pasangan : null;
        $kkj->anak = count($anaks) > 0 ? $anaks : [];
        $kkj->keluarga = count($keluargas) > 0 ? $keluargas : [];

        if($kkj->status != "waiting"){
            send_pdf_email($kkj, $kkj->email, "kkj");
            return redirect()->route("kkj.index")->with("msg_success", "Berhasil mengirim email");
        }
        return redirect()->route("kkj.index")->with("msg_info", "Belum bisa mengirim email");

        return back()->with("msg_success" , "Berhasil mengirimkan email");
    }

    public function edit(Kkj $kkj)
    {
        $data = Kkj::with(['wali', 'anggota_keluarga', 'urgent'])->find($kkj->id);

        $kepalaKeluarga = Wali::where('kkj_id', $kkj->id)->where('status', 'kepala keluarga')->first();
        $pasangan = Wali::where('kkj_id', $kkj->id)->where('status', 'pasangan')->first();
        
        $anaks = AnggotaKeluarga::with("baptiss")->where('kkj_id', $kkj->id)->where('hubungan', 'Anak')->get();
        $keluargas = AnggotaKeluarga::with("baptiss")->where('kkj_id', $kkj->id)->where('hubungan', "<>",'Anak')->get();
        
        $status_menikah = ["Sudah Menikah", "Belum Menikah", "Cerai"];
        $jenjangs = ['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', "D3", 'S1', 'S2', "S3"];
        $hubungans = ["Ayah", "Ibu", "Kakak", "Adik", "Suami", "Istri", "Keponakan", "Sepupu"];

        return view("kkj.form", compact("data", "status_menikah", 'jenjangs', 'hubungans', 'kepalaKeluarga', 'pasangan', 'anaks', 'keluargas'));
    }

    public function update(UpdateRequest $request, Kkj $kkj)
    {
        // try {
            $kkj = edit_kartu_kerluarga_jemaat($request->all(), $kkj->id);
            
            return redirect()->route("kkj.index")->with("msg_success", "Berhasil mengubah kartu keluarga jemaat");
        // } catch (\Throwable $th) {
        //     return redirect()->route("kkj.index")->with("msg_error", "Gagal mengubah kartu keluarga jemaat");
        // }
    }

    public function destroy(Kkj $kkj)
    {
        if(!$kkj) return abort(403, 'TIDAK ADA DATA TERSEBUT');

        $kkj->delete();

        return redirect()->route("kkj.index")->with("msg_success", "Berhasil menghapus kartu keluarga jemaat");
    }

    public function destroyAnak($id)
    {
        $kkjAnak = AnggotaKeluarga::find($id);
        if(!$kkjAnak) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $kkjAnak->delete();

        return back()->with("msg_success", "Berhasil menghapus anak");
    }

    public function destroyKeluarga($id)
    {
        $kkjKeluarga = AnggotaKeluarga::find($id);
        if(!$kkjKeluarga) return abort(403, "TIDAK ADA DATA TERSEBUT");

        $kkjKeluarga->delete();

        return back()->with("msg_success", "Berhasil menghapus keluarga");
    }
}
