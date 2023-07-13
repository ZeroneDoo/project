<?php

namespace App\Http\Controllers;

use App\Models\{
    Baptis,
    Kkj,
    KkjAnak,
    KkjKeluarga,
    Penyerahan
};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyerahanBaptisController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->search;
        $dataKkj = Kkj::with('kkj_kepala_keluarga','kkj_pasangan', 'kkj_anak', 'kkj_keluarga', 'urgent')->where('kode', $query)->first();
        
        if(isset($dataKkj->kkj_anak) || isset($dataKkj->kkj_keluarga)){
            $datas = $dataKkj->kkj_anak->concat($dataKkj->kkj_keluarga);
        }

        $hubungan = '';

        if($dataKkj) return view('penyerahan_baptis.index', compact('datas', 'hubungan'));
        
        return view('penyerahan_baptis.index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'kkj_anak_id' => $request->hubungan == "anak" ? $request->id : null,
                'kkj_keluarga_id' => $request->hubungan =="keluarga" ? $request->id : null,
                'waktu' => Carbon::parse($request->waktu, 'Asia/Jakarta'),
                'pendeta' => $request->pendeta,
            ];
            
            if(!isset($request->baptis) && !isset($request->penyerahan)) return back()->with("msg_error", "Gagal membuat data penyerahan/baptis");
            
            if($request->baptis == "on"){
                // foto
                if($request->foto){
                    $path = Storage::disk('public')->put('baptis', $request->foto);
                    $data['foto'] = $path;
                }
                
                $dataBaptis = Baptis::create($data);
                // hubungan
                if($request->hubungan == "anak"){
                    $anak = KkjAnak::with('kkj', 'baptiss', 'penyerahan', 'kkj_kepala_keluarga', 'kkj_pasangan')->find($request->id);
                    $anak->update(['baptis' => "Y"]);
                }else if($request->hubungan == "keluarga"){
                    $anak = KkjKeluarga::with('kkj', 'baptiss', 'penyerahan', 'kkj_kepala_keluarga', 'kkj_pasangan')->find($request->id);
                    $anak->update(['baptis' => "Y"]);
                }
                send_pdf_email($anak, $anak->kkj->email, 'baptis');
            } 

            if($request->penyerahan == "on"){
                // foto
                if($request->foto){
                    $path = Storage::disk('public')->put('penyerahan', $request->foto);
                    $data['foto'] = $path;
                }

                $dataPenyerahan = Penyerahan::create($data);
                // hubungan
                if($request->hubungan == "anak"){
                    $anak = KkjAnak::with('kkj', 'baptiss', 'penyerahan', 'kkj_kepala_keluarga', 'kkj_pasangan')->find($request->id);
                    $anak->update(['diserahkan' => "Y"]);
                }else if($request->hubungan == "keluarga"){
                    $anak = KkjKeluarga::with('kkj', 'baptiss', 'penyerahan', 'kkj_kepala_keluarga', 'kkj_pasangan')->find($request->id);
                    $anak->update(['diserahkan' => "Y"]);
                }
                send_pdf_email($anak, $anak->kkj->email, 'penyerahan');
            } 

            return back()->with("msg_success", "Berhasil membuat penyerahan/baptis");
        } catch (\Throwable $th) {
            return back()->with("msg_error", "Gagal membuat penyerahan/baptis");
        }
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
        if($request->hubungan == "anak"){
            $data = KkjAnak::with('kkj_pasangan', 'kkj_kepala_keluarga', 'kkj')->find($request->id);
        }else if($request->hubungan == "keluarga"){
            $data = KkjKeluarga::with('kkj_pasangan', 'kkj_kepala_keluarga', 'kkj')->find($request->id);
        }
        $data->tgl_lahir = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');
        return $data;
    }
}
