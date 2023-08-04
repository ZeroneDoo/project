<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Kkj;
use App\Models\Pengantin;
use App\Models\Penyerahan;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandlerController extends Controller
{
    public function formKkj ($id) {
        $data = Kkj::find($id);

        $pasangan = DB::select("SELECT * from walis where kkj_id = $data->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $anaks = DB::select("SELECT * from anggota_keluargas where kkj_id = $data->id and hubungan = 'anak' and deleted_at IS NULL");
        $keluargas = DB::select("SELECT * from anggota_keluargas where kkj_id = $data->id and hubungan <> 'anak' and deleted_at IS NULL");
        
        $data->kepala_keluarga = DB::select("SELECT * from walis where kkj_id = $data->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $data->pasangan = $pasangan ? $pasangan : null;
        $data->anak = count($anaks) > 0 ? $anaks : [];
        $data->keluarga = count($keluargas) > 0 ? $keluargas : [];
        
        return view("kkj.handler.detail", compact('data'));
    }
    public function requestKkj (Request $req, $id) {
        $data = Kkj::find($id);
        
        if($req->response == "false"){
            $data->delete();
            return redirect()->route("dashboard")->with("msg_success", "Kartu keluarga jemaat berhasil di tolak");
        }

        $data->update(['status' => "done"]);

        $pasangan = DB::select("SELECT * from walis where kkj_id = $data->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $anaks = DB::select("SELECT * from anggota_keluargas where kkj_id = $data->id and hubungan = 'anak' and deleted_at IS NULL");
        $keluargas = DB::select("SELECT * from anggota_keluargas where kkj_id = $data->id and hubungan <> 'anak' and deleted_at IS NULL");
        
        $data->kepala_keluarga = DB::select("SELECT * from walis where kkj_id = $data->id and status = 'kepala keluarga' and deleted_at IS NULL")[0];
        $data->pasangan = $pasangan ? $pasangan : null;
        $data->anak = count($anaks) > 0 ? $anaks : [];
        $data->keluarga = count($keluargas) > 0 ? $keluargas : [];

        send_pdf_email($data, $data->email, "kkj");

        return redirect()->route("dashboard")->with("msg_success", "Kartu keluarga jemaat berhasil di terima");
    }

    public function formBaptis ($id) {
        $data = Baptis::find($id);

        $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();

        return view("baptis.handler.detail", compact('data'));
    }
    public function requestBaptis (Request $req, $id) {
        $data = Baptis::find($id);

        if($req->response == "false"){
            $data->delete();

            return redirect()->route("dashboard")->with("msg_success", "Permintaan Baptis berhasil di tolak");
        }
        
        $data->update(['status' => "done"]);

        $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();

        send_pdf_email($data, $data->kkj->email, "baptis");

        return redirect()->route("dashboard")->with("msg_success", "Permintaan Baptis berhasil di terima");
    }

    public function formPenyerahan ($id) {
        $data = Penyerahan::find($id);

        $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();

        return view("penyerahan.handler.detail", compact('data'));
    }
    public function requestPenyerahan (Request $req, $id) {
        $data = Penyerahan::find($id);

        if($req->response == "false"){
            $data->delete();

            return redirect()->route("dashboard")->with("msg_success", "Permintaan penyerahan berhasil di tolak");
        }

        $data->update(['status' => "done"]);

        $data->kepala_keluarga = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "kepala keluarga")->whereNull("deleted_at")->first();
        $data->pasangan = DB::table('walis')->select("*")->where("kkj_id", $data->kkj->id)->where("status", "pasangan")->whereNull("deleted_at")->first();
        
        send_pdf_email($data, $data->kkj->email, "penyerahan");

        return redirect()->route("dashboard")->with("msg_success", "Permintaan penyerahan berhasil di terima");
    }

    public function formPernikahan ($id) {
        $data = Pernikahan::find($id);

        $data->pengantin_pria = Pengantin::where("pernikahan_id", $data->id)->where("jk",'pria')->whereNull("deleted_at")->first();
        $data->pengantin_wanita = Pengantin::where("pernikahan_id", $data->id)->where("jk",'wanita')->whereNull("deleted_at")->first();
        $kkj = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->kkj : $data->pengantin_wanita->anggota_keluarga->kkj;
        $baptis = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->baptiss : $data->pengantin_wanita->anggota_keluarga->baptiss->last();

        $data->kepala_keluarga = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'kepala keluarga' AND deleted_at is NULL")[0];
        $data->pasangan = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'pasangan' AND deleted_at is NULL")[0];
        $data->baptiss = $baptis;
        $data->kkj = $kkj;

        return view("pernikahan.handler.detail", compact('data'));
    }
    public function requestPernikahan (Request $req, $id) {
        $data = Pernikahan::find($id);

        if($req->response == "false"){
            $data->delete();

            return redirect()->route("dashboard")->with("msg_success", "Permintaan pernikahan berhasil di tolak");
        }

        $data->update(['status'=> "done"]);
        
        $data->pengantin_pria = Pengantin::where("pernikahan_id", $data->id)->where("jk",'pria')->whereNull("deleted_at")->first();
        $data->pengantin_wanita = Pengantin::where("pernikahan_id", $data->id)->where("jk",'wanita')->whereNull("deleted_at")->first();
        $kkj = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->kkj : $data->pengantin_wanita->anggota_keluarga->kkj;
        $baptis = $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->baptiss : $data->pengantin_wanita->anggota_keluarga->baptiss->last();
        
        $data->kepala_keluarga = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'kepala keluarga' AND deleted_at is NULL")[0];
        $data->pasangan = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'pasangan' AND deleted_at is NULL")[0];
        $data->baptiss = $baptis;
        $data->kkj = $kkj;

        send_pdf_email($data, $data->email,"pernikahan");

        return redirect()->route("dashboard")->with("msg_success", "Permintaan pernikahan berhasil di terima");
    }
}
