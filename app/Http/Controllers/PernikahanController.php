<?php

namespace App\Http\Controllers;

use App\Models\{
    AnggotaKeluarga,
    Baptis,
    Kkj,
    Pernikahan,
    Wali,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class PernikahanController extends Controller
{
    public function index()
    {
        $datas = Pernikahan::with('pengantin', 'pengantin.anggota_keluarga')->paginate(4);

        return view("pernikahan.index", compact('datas'));
    }

    public function create()
    {
        return view('pernikahan.form');
    }

    public function store(Request $request)
    {
        try {
            $data = create_form_pernikahan($request->all());
            
            send_pdf_email($data, $request->email, 'pernikahan');

            return redirect()->route('pernikahan.index')->with('msg_success', "Berhasil membuat formulir pernikahan");
        } catch (\Throwable $th) {
            return redirect()->route('pernikahan.index')->with('msg_error', "Gagal membuat formulir pernikahan");
        }
    }

    public function show(Pernikahan $pernikahan)
    {
        //
    }

    public function edit($id)
    {
        $data = Pernikahan::with('pengantin_pria', 'pengantin_wanita')->find($id);
        return view('pernikahan.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = edit_form_pernikahan($request->all(), $id);
            send_pdf_email($data, $request->email, 'pernikahan');

            return redirect()->route('pernikahan.index')->with('msg_success', "Berhasil mengubah formulir pernikahan");
        } catch (\Throwable $th) {
            return redirect()->route('pernikahan.index')->with('msg_error', "Gagal mengubah formulir pernikahan");
        }
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

            $data->baptiss = Baptis::find($data->id);
            $data->baptiss->waktu_format = Carbon::parse($data->baptiss->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i');

            $data->tgl_lahir_format = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');

            return $data;
        } catch (\Throwable $th) {
            return "info";
        }
    }
}
