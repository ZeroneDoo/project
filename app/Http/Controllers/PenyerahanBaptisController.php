<?php

namespace App\Http\Controllers;

use App\Models\{
    AnggotaKeluarga,
    Baptis,
    Kkj,
    Penyerahan,
    Wali
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
            $kkj = Kkj::where('kode', $request->search)->first();

            $data = [
                "kkj_id" => $kkj->id,
                'anggota_keluarga_id' => $request->id,
                'waktu' => Carbon::parse($request->waktu, 'Asia/Jakarta'),
                'pendeta' => $request->pendeta,
                "status" => "waiting"
            ];
            
            if(!isset($request->baptis) && !isset($request->penyerahan)) return back()->with("msg_error", "Gagal membuat data penyerahan/baptis");
            
            if($request->baptis == "on"){
                // foto
                if($request->foto){
                    $path = Storage::disk('public')->put('baptis', $request->foto);
                    $data['foto'] = $path;
                }
                
                $dataBaptis = Baptis::create($data);

                $dataBaptis->kepala_keluarga = Wali::where('kkj_id', $dataBaptis->kkj_id)->where('status', 'kepala keluarga')->first();
                $dataBaptis->pasangan = Wali::where('kkj_id', $dataBaptis->kkj_id)->where('status', 'pasangan')->first();
                
                send_pdf_email($dataBaptis, $dataBaptis->kkj->email, 'baptis');
            } 

            if($request->penyerahan == "on"){
                // foto
                if($request->foto){
                    $path = Storage::disk('public')->put('penyerahan', $request->foto);
                    $data['foto'] = $path;
                }

                $dataPenyerahan = Penyerahan::create($data);

                $dataPenyerahan->kepala_keluarga = Wali::where('kkj_id', $dataPenyerahan->kkj_id)->where('status', 'kepala keluarga')->first();
                $dataPenyerahan->pasangan = Wali::where('kkj_id', $dataPenyerahan->kkj_id)->where('status', 'pasangan')->first();

                send_pdf_email($dataPenyerahan, $dataPenyerahan->kkj->email, 'penyerahan');
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
        $data = AnggotaKeluarga::with("kkj", "baptiss")->find($request->id);

        $data->kepala_keluarga = Wali::where('kkj_id', $data->kkj->id)->where('status', 'kepala keluarga')->first();
        $data->pasangan = Wali::where('kkj_id', $data->kkj->id)->where('status', 'pasangan')->first();
        $data->tgl_lahir = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');

        return $data;
    }
}
