<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Pendeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendetaController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkRoleSuperAdmin");
    }
    public function index()
    {
        $datas = Pendeta::where("is_active" , "1")->paginate(4);
        return view("pendeta.index", compact('datas'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view("pendeta.form", compact("cabangs"));
    }

    public function store(Request $request)
    {
        try {
            $data = [
                "nama" => $request->nama,
            ];

            if($request->hasFile("foto")){
                $path = Storage::disk("public")->put("pendeta", $request->foto);
                $data['foto'] = $path;
            }

            Pendeta::create($data);

            return redirect()->route("pendeta.index")->with("msg_success", "Berhasil menambahkan pendeta");
        } catch (\Throwable $th) {
            return redirect()->route("pendeta.index")->with("msg_error", "Gagal menambahkan pendeta");
        }
    }

    public function show(Pendeta $pendeta)
    {
        //
    }

    public function edit($id)
    {
        $data = Pendeta::find($id);
        $cabangs = Cabang::all();
        return view("pendeta.form", compact('data', "cabangs"));
    }

    public function update(Request $request, $id)
    {
        try {
            $pendeta = Pendeta::find($id);

            $data = [
                "nama" => $request->nama,
            ];

            if($request->hasFile("foto")){
                if(Storage::disk("public")->exists("$pendeta->foto")){
                    Storage::disk("public")->delete("$pendeta->foto");
                }
                $path = Storage::disk("public")->put("pendeta", $request->foto);
                $data['foto'] = $path;
            }

            $pendeta->update($data);

            return redirect()->route("pendeta.index")->with("msg_success", "Berhasil mengubah pendeta");
        } catch (\Throwable $th) {
            return redirect()->route("pendeta.index")->with("msg_error", "Gagal mengubah pendeta");
        }
    }

    public function destroy($id)
    {
        $pendeta = Pendeta::find($id);

        if(!$pendeta) abort(404);

        if(Storage::disk("public")->exists("$pendeta->foto")){
            Storage::disk("public")->delete("$pendeta->foto");
        }

        $pendeta->update(['is_active' => false]);

        return redirect()->route("pendeta.index")->with("msg_success", "Berhasil menghapus pendeta");
    }
}
