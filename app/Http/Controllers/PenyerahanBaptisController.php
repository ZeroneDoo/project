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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenyerahanBaptisController extends Controller
{
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
            $data = AnggotaKeluarga::with("kkj", "baptiss")->find($request->id);
            $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
            $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();
            $data->tgl_lahir = Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y');

            return $data;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
