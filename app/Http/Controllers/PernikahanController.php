<?php

namespace App\Http\Controllers;

use App\Models\{
    AnggotaKeluarga,
    Baptis,
    Kkj,
    Pengantin,
    Pernikahan,
    Wali,
};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PernikahanController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRolePernikahan");
    }
    public function index()
    {
        $datas = Pernikahan::with('pengantin', 'pengantin.anggota_keluarga')->where("status", "done")->paginate(4);
        
        return view("pernikahan.index", compact('datas'));
    }

    public function create()
    {
        return view('pernikahan.form');
    }

    public function store(Request $request)
    {
        // try {
            $data = create_form_pernikahan($request->all());
            
            return redirect()->route('pernikahan.index')->with('msg_success', "Berhasil membuat formulir pernikahan");
        // } catch (\Throwable $th) {
        //     return redirect()->route('pernikahan.index')->with('msg_error', "Gagal membuat formulir pernikahan");
        // }
    }

    public function show(Pernikahan $pernikahan)
    {
        if(!$pernikahan) return back()->with("msg_error", "Gagal menampilkan form edit");

        $pernikahan->pengantin_pria = Pengantin::where("pernikahan_id", $pernikahan->id)->where("jk",'pria')->whereNull("deleted_at")->first();
        $pernikahan->pengantin_wanita = Pengantin::where("pernikahan_id", $pernikahan->id)->where("jk",'wanita')->whereNull("deleted_at")->first();
        $kkj = $pernikahan->pengantin_pria->anggota_keluarga ? $pernikahan->pengantin_pria->anggota_keluarga->kkj : $pernikahan->pengantin_wanita->anggota_keluarga->kkj;
        $baptis = $pernikahan->pengantin_pria->anggota_keluarga ? $pernikahan->pengantin_pria->anggota_keluarga->baptiss->last() : $pernikahan->pengantin_wanita->anggota_keluarga->baptiss->last();

        $pernikahan->kepala_keluarga = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'kepala keluarga' AND deleted_at is NULL")[0];
        $pernikahan->pasangan = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'pasangan' AND deleted_at is NULL")&&[0];
        $pernikahan->baptiss = $baptis;
        $pernikahan->kkj = $kkj;

        if($pernikahan->status == "done"){
            send_pdf_email($pernikahan, $pernikahan->email, 'pernikahan');
            return redirect()->route("pernikahan.index")->with("msg_success", "Berhasil mengirim email");
        }

        return redirect()->route("pernikahan.index")->with("msg_info", "Belum bisa mengirim email");
    }

    public function edit($id)
    {
        $data = Pernikahan::with('pengantin')->find($id);
        if(!$data) return back()->with("msg_error", "Gagal menampilkan form edit");

        $data->pengantin_pria = Pengantin::where("pernikahan_id", $data->id)->where("jk",'pria')->whereNull("deleted_at")->first();
        $data->pengantin_wanita = Pengantin::where("pernikahan_id", $data->id)->where("jk",'wanita')->whereNull("deleted_at")->first();
        $kkj = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->kkj : $data->pengantin_wanita->anggota_keluarga->kkj;
        $baptis = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->baptiss->last() : $data->pengantin_wanita->anggota_keluarga->baptiss->last();

        $data->kepala_keluarga = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'kepala keluarga' AND deleted_at is NULL")[0];
        $data->pasangan = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'pasangan' AND deleted_at is NULL")&&[0];
        $data->baptiss = $baptis;
        $data->kkj = $kkj;

        return view('pernikahan.formEdit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // try {
            $data = edit_form_pernikahan($request->all(), $id);

            return redirect()->route('pernikahan.index')->with('msg_success', "Berhasil mengubah formulir pernikahan");
        // } catch (\Throwable $th) {
        //     return redirect()->route('pernikahan.index')->with('msg_error', "Gagal mengubah formulir pernikahan");
        // }
    }

    public function destroy(Pernikahan $pernikahan)
    {
        if(!$pernikahan) return abort(403, 'DATA TERSEBUT TIDAK TERSEDIA');

        $pernikahan->delete();

        return redirect()->route('pernikahan.index')->with('msg_success', 'Berhasil menghapus data pernikahan');
    }

    public function searchKkj(Request $request)
    {
        $dataKkj = Kkj::where('kode', $request->kode)->first();

        if($request->hubungan =="anak"){
            $datas = AnggotaKeluarga::where("kkj_id",$dataKkj->id)->where('hubungan', 'Anak')->get();
        }else if ($request->hubungan =="keluarga"){
            $datas = AnggotaKeluarga::where("kkj_id",$dataKkj->id)->where('hubungan', "<>",'Anak')->get();
        }

        return $datas;
    }

    public function getKandidat(Request $request)
    {
        try {
            $data = AnggotaKeluarga::with('kkj')->find($request->id);
            $data->kepala_keluarga = Wali::where('kkj_id', $data->kkj->id)->where('status', 'kepala keluarga')->first();
            $data->pasangan = Wali::where('kkj_id', $data->kkj->id)->where('status', 'pasangan')->first();

            $data->baptiss = $data->baptiss->last();
            $data->baptiss->waktu_format = Carbon::parse($data->baptiss->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i');

            $data->tgl_lahir_format = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');

            return $data;
        } catch (\Throwable $th) {
            return "info";
        }
    }
}
