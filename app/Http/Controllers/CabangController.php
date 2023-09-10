<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\CabangIbadah;
use App\Models\Kegiatan;
use App\Models\PendetaCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CabangController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRoleSuperAdmin");
    }

    public function index()
    {
        $datas = Cabang::paginate(4);
        return view("cabang.index", compact("datas"));
    }

    public function create()
    {
        return view("cabang.form");
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                "nama" => $request->nama,
                "alamat" => $request->alamat,
                "deskripsi" => $request->deskripsi,
            ];

            if($request->foto){
                $path = Storage::disk("public")->put("cabang", $request->foto);
                $data['foto'] = $path;
            }

            $cabang = Cabang::create($data);

            // pendeta
            if(isset($request->pendeta)){
                $this->createPendeta($request, $cabang);
            }

            // ibadah
            if(isset($request->jadwal_ibadah)){
                $this->createJadwalIbadah($request, $cabang);
            }

            // kegiatan
            if(isset($request->kegiatan)){
                $this->createListKegiatan($request, $cabang);
            }
            DB::commit();            

            return redirect()->route("cabang.index")->with("msg_success", "Berhasil menambahkan cabang");
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route("cabang.index")->with("msg_error", "Gagal menambahkan cabang");
        }
    }

    public function show(Cabang $cabang)
    {
        //
    }

    public function edit($id)
    {
        $data = Cabang::find($id);
        return view("cabang.form", compact("data"));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cabang = Cabang::find($id);

            $data = [
                "nama" => $request->nama,
                "alamat" => $request->alamat,
                "deskripsi" => $request->deskripsi,
            ];

            if($request->foto){
                if(Storage::disk("public")->exists("$cabang->foto")){
                    Storage::disk("public")->delete("$cabang->foto");
                }
                $path = Storage::disk("public")->put("cabang", $request->foto);
                $data['foto'] = $path;
            }

            $cabang->update($data);

            // create pendeta
            if(isset($request->pendeta)){
                $this->createPendeta($request, $cabang);
            }
            // update update
            if(isset($request->pendeta_edit_id)){
                foreach ($request->pendeta_edit_id as $i => $pendeta_edit_id) {
                    $pendeta_cabang = PendetaCabang::find($pendeta_edit_id);
                    $pendeta_cabang->update([
                        "pendeta" => $request->pendeta_edit[$i]
                    ]);
                }
            }

            // create ibadah
            if(isset($request->jadwal_ibadah)){
                $this->createJadwalIbadah($request, $cabang);
            }
            // update ibadah
            if(isset($request->ibadah_edit_id)){
                foreach ($request->ibadah_edit_id as $i => $ibadah_edit_id) {
                    $ibadah_cabang = CabangIbadah::find($ibadah_edit_id);
                    $ibadah_cabang->update([
                        "hari" => $request->hari_ibadah_edit[$i],
                        "waktu" => $request->waktu_ibadah_edit[$i],
                    ]);
                }
            }

            // create kegiatan
            if(isset($request->kegiatan)){
                $this->createListKegiatan($request, $cabang);
            }

            // update kegiatan
            if(isset($request->kegiatan_edit_id)){
                foreach($request->kegiatan_edit_id as $i => $kegiatan_edit_id){
                    $kegiatan = Kegiatan::find($kegiatan_edit_id);
                    $kegiatan->update([
                        "nama" => $request->nama_kegiatan_edit[$i],
                        "pendeta" => $request->pendeta_kegiatan_edit[$i],
                        "area" => $request->area_kegiatan_edit[$i],
                        "waktu" => $request->waktu_kegiatan_edit[$i],
                    ]);
                }
            }
            DB::commit();            

            return redirect()->route("cabang.index")->with("msg_success", "Berhasil mengubah cabang");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route("cabang.index")->with("msg_error", "Gagal mengubah cabang");
        }
    }

    public function destroy($id)
    {
        $cabang = Cabang::find($id);

        if(!$cabang) return redirect()->route("cabang.index")->with("msg_error", "Gagal menghapus cabang");

        $cabang->delete();

        return redirect()->route("cabang.index")->with("msg_success", "Berhasil menambahkan cabang");
    }

    public function destroyPendeta($id)
    {
        $pendeta_cabang = PendetaCabang::find($id);

        if(!$pendeta_cabang) return redirect()->back()->with("msg_error", "Gagal menghapus pendeta cabang");

        $pendeta_cabang->delete();

        return redirect()->back()->with("msg_success", "Berhasil menghapus pendeta cabang");
    }

    public function destroyJadwalIbadah($id)
    {
        $ibadah_cabang = CabangIbadah::find($id);

        if(!$ibadah_cabang) return redirect()->back()->with("msg_error", "Gagal menghapus ibadah cabang");

        $ibadah_cabang->delete();

        return redirect()->back()->with("msg_success", "Berhasil menghapus ibadah cabang");
    }

    public function destroyListKegiatan($id)
    {
        $kegiatan = Kegiatan::find($id);

        if(!$kegiatan) return redirect()->back()->with("msg_error", "Gagal menghapus kegiatan cabang");

        $kegiatan->delete();

        return redirect()->back()->with("msg_success", "Berhasil menghapus kegiatan cabang");
    }

    private function createPendeta($request, $cabang){
        foreach ($request->pendeta as $pendeta) {
            PendetaCabang::create([
                "cabang_id" => $cabang->id,
                "pendeta" => $pendeta
            ]);
        }
    }

    private function createJadwalIbadah($request, $cabang){
        foreach ($request->jadwal_ibadah as $i => $jadwal_ibadah) {
            CabangIbadah::create([
                "cabang_id" => $cabang->id,
                "hari" => $request->hari[$i],
                "waktu" => $request->waktu[$i],
            ]);
        }
    }

    private function createListKegiatan($request, $cabang) {
        foreach($request->kegiatan as $i =>$kegiatan){
            Kegiatan::create([
                "cabang_id" => $cabang->id,
                "nama" => $request->nama_kegiatan[$i],
                "pendeta" => $request->pendeta_kegiatan[$i],
                "area" => $request->area_kegiatan[$i],
                "waktu" => $request->waktu_kegiatan[$i],
            ]);
        }
    }
}
