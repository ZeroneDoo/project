<?php

use App\Models\{
    Kkj,
    KkjAnak,
    KkjKeluarga,
    KkjPasangan,
    KkjKepalaKeluarga,
};
use Illuminate\Support\Facades\Http;

if(! function_exists("kartu_keluarga_jemaat")){
    function kartu_keluarga_jemaat($request){

        $prov = getNamaProvinsi($request["provinsi"]);
        $kota = getNamaKota($request["kabupaten"]);
        $kecamatan = getNamaKecamatan($request["kecamatan"]);

        $code = generateCode();

        $dataKkj = [
            "kode" => $code,
            "nama_kepala_keluarga" => $request["nama_kepala_keluarga"],
            "email" => $request["email"],
            "jk" => $request["jk"],
            "alamat" => $request["alamat"],
            "rt_rw" => $request["rt_rw"],
            "telp" => $request["telp"],
            "provinsi" => $prov,
            "kabupaten" => $kota,
            "kecamatan" => $kecamatan,
            "status_menikah" => $request["status_menikah"],
            "cabang" => "Jakarta"
        ];
        // dd($dataKkj);
        $kkj = Kkj::create($dataKkj);

        // kepala keluarga
        $dataKepalaKeluarga = [
            "kkj_id" => $kkj->id,
            "nama" => $request["nama_kepala_keluarga"],
            "jk" => $request["jk"],
            "tmpt_lahir" => $request["tmpt_lahir"],
            "tgl_lahir" => $request["tgl_lahir"],
            "pendidikan_terakhir" => $request["pendidikan_terakhir"],
            "pekerjaan" => $request["pekerjaan"],
            "baptis" => $request["baptis_date"],
        ];

        KkjKepalaKeluarga::create($dataKepalaKeluarga);
        
        // pasangan
        $dataPasangan = [
            "kkj_id" => $kkj->id,
            "nama" => $request["nama_pasangan"],
            "jk" => $request["jk_pasangan"],
            "tmpt_lahir" => $request["tmpt_lahir_pasangan"],
            "tgl_lahir" => $request["tgl_lahir_pasangan"],
            "pendidikan_terakhir" => $request["pendidikan_terakhir_pasangan"],
            "pekerjaan" => $request["pekerjaan_pasangan"],
            "baptis" => $request["baptis_date_pasangan"],
        ];
        
        $request['status_menikah'] == "Sudah Menikah" ? KkjPasangan::create($dataPasangan) : null;

        // anak
        if(isset($request["anak"])){
            foreach ($request["anak"] as $i => $anak) {
                $dataAnak = [
                    "kkj_id" => $kkj->id,
                    "nama" => $request["nama_anak"][$i],
                    "jk" => $request["jk_anak"][$i],
                    "tmpt_lahir" => $request["tmpt_lahir_anak"][$i],
                    "tgl_lahir" => $request["tgl_lahir_anak"][$i],
                    "pendidikan" => $request["pendidikan_anak"][$i],
                    "pekerjaan" => $request["pekerjaan_anak"][$i],
                    "diserahkan" => $request["diserahkan_anak"][$i],
                    "baptis" => $request["baptis_anak"][$i],
                    "nikah" => $request["nikah_anak"][$i],
                ];
                
                KkjAnak::create($dataAnak);
            }
        }

        // keluarga
        if(isset($request["keluarga"])){
            foreach ($request["keluarga"] as $i => $keluarga) {
                $dataKeluarga = [
                    "kkj_id" => $kkj->id,
                    "nama" => $request["nama_keluarga"][$i],
                    "jk" => $request["jk_keluarga"][$i],
                    "tmpt_lahir" => $request["tmpt_lahir_keluarga"][$i],
                    "tgl_lahir" => $request["tgl_lahir_keluarga"][$i],
                    "pendidikan" => $request["pendidikan_keluarga"][$i],
                    "pekerjaan" => $request["pekerjaan_keluarga"][$i],
                    "diserahkan" => $request["diserahkan_keluarga"][$i],
                    "baptis" => $request["baptis_keluarga"][$i],
                    "nikah" => $request["nikah_keluarga"][$i],
                ];
    
                KkjKeluarga::create($dataKeluarga);
            }
        }
    }
}

if(! function_exists("edit_kartu_kerluarga_jemaat")){
    function edit_kartu_kerluarga_jemaat($req, $idkkj) {
        $prov = getNamaProvinsi($req["provinsi"]);
        $kota = getNamaKota($req["kabupaten"]);
        $kecamatan = getNamaKecamatan($req["kecamatan"]);

        $kkj = Kkj::find($idkkj);

        $dataKkj = [
            "nama_kepala_keluarga" => $req["nama_kepala_keluarga"],
            "email" => $req["email"],
            "jk" => $req["jk"],
            "alamat" => $req["alamat"],
            "rt_rw" => $req["rt_rw"],
            "telp" => $req["telp"],
            "provinsi" => $prov,
            "kabupaten" => $kota,
            "kecamatan" => $kecamatan,
            "status_menikah" => $req["status_menikah"],
        ];

        $kkj->update($dataKkj);
        
        // kepala keluarga
        $kkjKepalaKeluarga = KkjKepalaKeluarga::where("kkj_id", $idkkj)->first();

        $dataKepalaKeluarga = [
            "nama" => $req["nama_kepala_keluarga"],
            "jk" => $req["jk"],
            "tmpt_lahir" => $req["tmpt_lahir"],
            "tgl_lahir" => $req["tgl_lahir"],
            "pendidikan_terakhir" => $req["pendidikan_terakhir"],
            "pekerjaan" => $req["pekerjaan"],
            "baptis" => $req["baptis_date"],
        ];
        $kkjKepalaKeluarga->update($dataKepalaKeluarga);

        // pasangan
        $kkjPasangan = KkjPasangan::where("kkj_id", $idkkj)->first();

        $dataPasangan = [
            "nama" => $req["nama_pasangan"],
            "jk" => $req["jk_pasangan"],
            "tmpt_lahir" => $req["tmpt_lahir_pasangan"],
            "tgl_lahir" => $req["tgl_lahir_pasangan"],
            "pendidikan_terakhir" => $req["pendidikan_terakhir_pasangan"],
            "pekerjaan" => $req["pekerjaan_pasangan"],
            "baptis" => $req["baptis_date_pasangan"],
        ];
        $req['status_menikah'] == "Cerai" ? $kkjPasangan->delete() : $kkjPasangan->update($dataPasangan);

        // anak create
        if(isset($req["anak"])){
            foreach ($req["anak"] as $i => $dumpanak) {
                $dataAnak = [
                    "kkj_id" => $idkkj,
                    "nama" => $req["nama_anak"][$i],
                    "jk" => $req["jk_anak"][$i],
                    "tmpt_lahir" => $req["tmpt_lahir_anak"][$i],
                    "tgl_lahir" => $req["tgl_lahir_anak"][$i],
                    "pendidikan" => $req["pendidikan_anak"][$i],
                    "pekerjaan" => $req["pekerjaan_anak"][$i],
                    "diserahkan" => $req["diserahkan_anak"][$i],
                    "baptis" => $req["baptis_anak"][$i],
                    "nikah" => $req["nikah_anak"][$i],
                ];
                
                KkjAnak::create($dataAnak);
            }
        }
        // anak edit
        if(isset($req["id_anak"])){
            foreach ($req["id_anak"] as $i => $anak) {
                $kkjAnak = KkjAnak::find($anak);
                
                $dataAnak = [
                    "nama" => $req["nama_anak_edit"][$i],
                    "jk" => $req["jk_anak_edit"][$i],
                    "tmpt_lahir" => $req["tmpt_lahir_anak_edit"][$i],
                    "tgl_lahir" => $req["tgl_lahir_anak_edit"][$i],
                    "pendidikan" => $req["pendidikan_anak_edit"][$i],
                    "pekerjaan" => $req["pekerjaan_anak_edit"][$i],
                    "diserahkan" => $req["diserahkan_anak_edit"][$i],
                    "baptis" => $req["baptis_anak_edit"][$i],
                    "nikah" => $req["nikah_anak_edit"][$i],
                ];
                
                $kkjAnak->update($dataAnak);
            }
        }

        // keluarga create
        if(isset($req["keluarga"])){
            foreach ($req["keluarga"] as $i => $dumpkeluarga) {
                $dataKeluarga = [
                    "kkj_id" => $idkkj,
                    "nama" => $req["nama_keluarga"][$i],
                    "jk" => $req["jk_keluarga"][$i],
                    "tmpt_lahir" => $req["tmpt_lahir_keluarga"][$i],
                    "tgl_lahir" => $req["tgl_lahir_keluarga"][$i],
                    "pendidikan" => $req["pendidikan_keluarga"][$i],
                    "pekerjaan" => $req["pekerjaan_keluarga"][$i],
                    "diserahkan" => $req["diserahkan_keluarga"][$i],
                    "baptis" => $req["baptis_keluarga"][$i],
                    "nikah" => $req["nikah_keluarga"][$i],
                ];
                
                KkjKeluarga::create($dataKeluarga);
            }
        }
        // keluarga edit
        if(isset($req["id_keluarga"])){
            foreach ($req["id_keluarga"] as $i => $keluarga) {
                $kkjKeluarga = KkjKeluarga::find($keluarga);
                
                $dataKeluarga = [
                    "nama" => $req["nama_keluarga_edit"][$i],
                    "jk" => $req["jk_keluarga_edit"][$i],
                    "tmpt_lahir" => $req["tmpt_lahir_keluarga_edit"][$i],
                    "tgl_lahir" => $req["tgl_lahir_keluarga_edit"][$i],
                    "pendidikan" => $req["pendidikan_keluarga_edit"][$i],
                    "pekerjaan" => $req["pekerjaan_keluarga_edit"][$i],
                    "diserahkan" => $req["diserahkan_keluarga_edit"][$i],
                    "baptis" => $req["baptis_keluarga_edit"][$i],
                    "nikah" => $req["nikah_keluarga_edit"][$i],
                ];
                
                $kkjKeluarga->update($dataKeluarga);
            }
        }
    }
}

if(! function_exists("getNamaProvinsi")){
    function getNamaProvinsi($id){
        $data = Http::get("https://dev.farizdotid.com/api/daerahindonesia/provinsi/".$id)->json();
        return $data["nama"];
    }
}

if(! function_exists("getNamaKota")){
    function getNamaKota($id){
        $data = Http::get("https://dev.farizdotid.com/api/daerahindonesia/kota/".$id)->json();
        return $data["nama"];
    }
}

if(! function_exists("getNamaKecamatan")){
    function getNamaKecamatan($id){
        $data = Http::get("https://dev.farizdotid.com/api/daerahindonesia/kecamatan/".$id)->json();
        return $data["nama"];
    }
}

if(! function_exists("generateCode")){
    function generateCode(){
        $prefix = "KKJ";
        $length = 7;
        // $code = $prefix . substr(uniqid(), 0, $length);
        
        $uniqueid = crc32(uniqid());
        $code = $prefix . abs($uniqueid);

        return $code;
    }
}