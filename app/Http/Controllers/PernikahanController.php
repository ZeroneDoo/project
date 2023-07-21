<?php

namespace App\Http\Controllers;

use App\Models\{
    Kkj,
    KkjAnak,
    KkjKeluarga,
    Pernikahan,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class PernikahanController extends Controller
{
    public function index()
    {
        $datas = Pernikahan::with('pengantin_pria', 'pengantin_wanita')->paginate(4);
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
            $data->pengantin_wanita = $data->pengantin[0]->jk_pengantin == "Wanita" ? $data->pengantin[0] : $data->pengantin[1]; 
            $data->pengantin_pria = $data->pengantin[0]->jk_pengantin == "Pria" ? $data->pengantin[0] : $data->pengantin[1]; 
            
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

        $pernikahan->pengantin_pria->delete();
        $pernikahan->pengantin_wanita->delete();
        $pernikahan->delete();

        return redirect()->route('pernikahan.index')->with('msg_success', 'Berhasil menghapus data pernikahan');
    }

    public function searchKkj(Request $request)
    {
        $dataKkj = Kkj::with('kkj_kepala_keluarga','kkj_pasangan', 'kkj_anak', 'kkj_keluarga', 'urgent')->where('kode', $request->kode)->first();

        if($request->hubungan =="anak"){
            $datas = $dataKkj->kkj_anak;
        }else if ($request->hubungan =="keluarga"){
            $datas = $dataKkj->kkj_keluarga;
        }

        return $datas;
    }

    public function getKandidat(Request $request)
    {
        try {
            if($request->hubungan == "anak"){
                $data = KkjAnak::with('kkj_pasangan', 'kkj_kepala_keluarga', 'kkj', 'baptiss')->find($request->id);
            }else if($request->hubungan == "keluarga"){
                $data = KkjKeluarga::with('kkj_pasangan', 'kkj_kepala_keluarga', 'kkj', 'baptiss')->find($request->id);
            }
    
            $data->baptiss->waktu_format = Carbon::parse($data->baptiss->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i');
            $data->tgl_lahir_format = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');
            return $data;
        } catch (\Throwable $th) {
            return "info";
        }
    }
}
