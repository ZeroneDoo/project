<?php

use App\Models\{
    AnggotaKeluarga,
    Baptis,
    Kkj,
    KkjAnak,
    KkjKeluarga,
    KkjPasangan,
    KkjKepalaKeluarga,
    Pengantin,
    PengantinPria,
    PengantinWanita,
    Pernikahan,
    Urgent,
    Wali,
};
use Carbon\Carbon;
use Illuminate\Support\Facades\{
    Auth,
    DB,
    View,
    Mail,
    Http,
    Storage
};
use Dompdf\{
    Dompdf,
    Options
};

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
            "status" => Auth::user()->role->nama == "Admin Kartu Keluarga" ? "done" : "waiting",
            "cabang" => "Jakarta"   
        ];

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
            "status" => "kepala keluarga",
        ];

        // foto
        if(isset($request['foto']) && isset($request['foto_baptis']) && isset($request['foto_kk'])){
            $pathFoto = Storage::disk("public")->put("kkj/kepalakeluarga", $request['foto']);
            $pathBaptis = Storage::disk("public")->put("kkj/baptis", $request['foto_baptis']);
            $pathKK = Storage::disk("public")->put("kkj/kk", $request['foto_kk']);
            $dataKepalaKeluarga['foto'] = $pathFoto;
            $dataKepalaKeluarga['foto_kk'] = $pathKK;
            $dataKepalaKeluarga['foto_baptis'] = $pathBaptis;
        }

        $kepalaKeluarga = Wali::create($dataKepalaKeluarga);
        
        // pasangan
        if(isset($request['pasangan'])){
            $dataPasangan = [
                "kkj_id" => $kkj->id,
                "nama" => $request["nama_pasangan"],
                "jk" => $request["jk_pasangan"],
                "tmpt_lahir" => $request["tmpt_lahir_pasangan"],
                "tgl_lahir" => $request["tgl_lahir_pasangan"],
                "pendidikan_terakhir" => $request["pendidikan_terakhir_pasangan"],
                "pekerjaan" => $request["pekerjaan_pasangan"],
                "baptis" => $request["baptis_date_pasangan"],
                "status" => 'pasangan'
            ];

            $pasangan = $request['status_menikah'] == "Sudah Menikah" ? Wali::create($dataPasangan) : null;
        }
        

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
                    "hubungan" => "Anak"
                ];
                
                $anak = AnggotaKeluarga::create($dataAnak);
                $anaks[] = $anak;

                // create baptis
                if($dataAnak['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "waktu" => $request['waktu_baptis_anak'][$i],
                        "anggota_keluarga_id" => $anak->id,
                        "status" => "done"
                    ]);
                }
            }
        }

        // keluarga
        if(isset($request["keluarga"])){
            foreach($request['hubungan_keluarga'] as $hubungan){
                if($hubungan != null) $request['hubungan_keluargas'][] = $hubungan;
            }
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
                    'hubungan' => $request['hubungan_keluargas'][$i],
                ];
                
                $keluarga = AnggotaKeluarga::create($dataKeluarga);
                $keluargas[] = $keluarga;

                // create baptis
                if($dataKeluarga['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "waktu" => $request['waktu_baptis_keluarga'][$i],
                        "anggota_keluarga_id" => $keluarga->id,
                        "status" => "done"
                    ]);
                }
            }
        }

        // urgent
        $dataUrgent = [
            'kkj_id' => $kkj->id,
            'nama' => $request['nama_urgent'],
            'alamat' => $request['alamat_urgent'],
            'telp' => $request['telp_urgent'],
            'hubungan' => $request['hubungan_urgent'],
        ];

        Urgent::create($dataUrgent);

        return $kkj;
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
        $kkjKepalaKeluarga = Wali::where("kkj_id", $idkkj)->where('status', 'kepala keluarga')->first();

        $dataKepalaKeluarga = [
            "nama" => $req["nama_kepala_keluarga"],
            "jk" => $req["jk"],
            "tmpt_lahir" => $req["tmpt_lahir"],
            "tgl_lahir" => $req["tgl_lahir"],
            "pendidikan_terakhir" => $req["pendidikan_terakhir"],
            "pekerjaan" => $req["pekerjaan"],
            "baptis" => $req["baptis_date"],
        ];

        // update image
        if(isset($req['foto'])){
            $pathFoto = Storage::disk("public")->put("kkj/kepalakeluarga", $req['foto']);
            $dataKepalaKeluarga['foto'] = $pathFoto;
            if(Storage::disk("public")->exists("$kkjKepalaKeluarga->foto")){
                Storage::disk("public")->delete("$kkjKepalaKeluarga->foto");
            }
        }
        if(isset($req['foto_baptis'])){
            $pathBaptis = Storage::disk("public")->put("kkj/baptis", $req['foto_baptis']);
            $dataKepalaKeluarga['foto_baptis'] = $pathBaptis;
            if(Storage::disk("public")->exists("$kkjKepalaKeluarga->foto_baptis")){
                Storage::disk("public")->delete("$kkjKepalaKeluarga->foto_baptis");
            }
        }
        if(isset($req['foto_kk'])){
            $pathKk = Storage::disk("public")->put("kkj/kk", $req['foto_kk']);
            $dataKepalaKeluarga['foto_kk'] = $pathKk;
            if(Storage::disk("public")->exists("$kkjKepalaKeluarga->foto_kk")){
                Storage::disk("public")->delete("$kkjKepalaKeluarga->foto_kk");
            }
        }
        $kkjKepalaKeluarga->update($dataKepalaKeluarga);

        // pasangan
        if(isset($req['pasangan'])){
            $kkjPasangan = Wali::where("kkj_id", $idkkj)->where('status', 'pasangan')->first();

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
        }

        // anak edit
        if(isset($req["id_anak"])){
            foreach ($req["id_anak"] as $i => $anak) {
                $kkjAnak = AnggotaKeluarga::find($anak);
                
                $dataAnak = [
                    "nama" => $req["nama_anak_edit"][$i],
                    "jk" => $req["jk_anak_edit"][$i],
                    "tmpt_lahir" => $req["tmpt_lahir_anak_edit"][$i],
                    "tgl_lahir" => $req["tgl_lahir_anak_edit"][$i],
                    "pendidikan" => $req["pendidikan_anak_edit"][$i],
                    "pekerjaan" => $req["pekerjaan_anak_edit"][$i],
                    "diserahkan" => $req["diserahkan_anak_edit"][$i],
                    "baptis" => $req["baptis_anak_edit"][$i],
                    "has_nikah" => $req["nikah_anak_edit"][$i] == "Y" ? 1 : 0,
                    "nikah" => $req["nikah_anak_edit"][$i],
                ];
                
                $kkjAnak->update($dataAnak);
                $anaks[] = $kkjAnak;

                $baptisAnak = Baptis::where("anggota_keluarga_id", $kkjAnak->id)->first();
                if($baptisAnak){
                    $baptisAnak->update([
                        "waktu" => $req['waktu_baptis_anak_edit'][$i],
                    ]);
                }else if(!$baptisAnak && $dataAnak['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "anggota_keluarga_id" => $kkjAnak->id,
                        "waktu" =>$req['waktu_baptis_anak_edit'][$i],
                        "status" => "done"
                    ]);
                }

            }
        }

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
                    "has_nikah" => $req["nikah_anak"][$i] == "Y" ? 1 : 0,
                    "hubungan" => "Anak"
                ];
                
                $anak = AnggotaKeluarga::create($dataAnak);
                $anaks[] = $anak;

                // create baptis
                if($dataAnak['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "waktu" => $req['waktu_baptis_anak'][$i],
                        "anggota_keluarga_id" => $anak->id,
                        "status" => "done"
                    ]);
                }
            }
        }

        // keluarga edit
        if(isset($req["id_keluarga"])){
            foreach ($req["id_keluarga"] as $i => $keluarga) {
                foreach($req['hubungan_keluarga_edit'] as $hubungan){
                    if($hubungan != null) $req['hubungan_keluargas_edit'][] = $hubungan;
                }
                $kkjKeluarga = AnggotaKeluarga::find($keluarga);
                
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
                    "has_nikah" => $req["nikah_keluarga_edit"][$i] == "Y" ? 1 : 0,
                    "hubungan" => $req["hubungan_keluargas_edit"][$i],
                ];
                
                $kkjKeluarga->update($dataKeluarga);
                $keluargas[] = $kkjKeluarga;

                $baptisKeluarga = Baptis::where("anggota_keluarga_id", $kkjKeluarga->id)->first();
                if($baptisKeluarga){
                    $baptisKeluarga->update([
                        "waktu" => $req['waktu_baptis_keluarga_edit'][$i],
                    ]);
                }else if(!$baptisKeluarga && $dataKeluarga['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "anggota_keluarga_id" => $kkjKeluarga->id,
                        "waktu" => $req['waktu_baptis_keluarga_edit'][$i],
                        "status" => "done"
                    ]);
                }

            }
        }

        // keluarga create
        if(isset($req["keluarga"])){
            foreach ($req["keluarga"] as $i => $dumpkeluarga) {
                foreach($req['hubungan_keluarga'] as $hubungan){
                    if($hubungan != null) $req['hubungan_keluargas'][] = $hubungan;
                }
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
                    "has_nikah" => $req["nikah_keluarga"][$i] == "Y" ? 1 : 0,
                    "hubungan" => $req["hubungan_keluargas"][$i],
                ];
                $keluarga = AnggotaKeluarga::create($dataKeluarga);
                $keluargas[] = $keluarga;

                if($dataKeluarga['baptis'] == "Y"){
                    Baptis::create([
                        "kkj_id" => $kkj->id,
                        "waktu" => $req['waktu_baptis_keluarga'][$i],
                        "anggota_keluarga_id" => $keluarga->id,
                        "status" => "done"
                    ]);
                }
            }
        }

        // urgent
        $urgent = Urgent::where('kkj_id', $kkj->id)->first();
        $dataUrgent = [
            'nama' => $req['nama_urgent'],
            'alamat' => $req['alamat_urgent'],
            'telp' => $req['telp_urgent'],
            'hubungan' => $req['hubungan_urgent'],
        ];

        $urgent->update($dataUrgent);

        return $kkj;
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
        $date = Carbon::now('Asia/Jakarta')->format('m-y');
        // $code = $prefix . substr(uniqid(), 0, $length);
        
        $uniqueid = crc32(uniqid());
        $code = abs($uniqueid)."/$prefix/11H001/$date" ;

        return $code;
    }
}

if(! function_exists('send_pdf_email')){
    function send_pdf_email($data, $email, $file){
        // setup pdf
        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $dompdf = new Dompdf($options);
        $file == "kkj" ? $dompdf->setPaper('A3', 'landscape') : $dompdf->setPaper('A4', 'potrait');

        $html = View::make("pdf.$file.$file", ['data' => $data])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        // output pdf
        $pdfOutput = $dompdf->output();

        if($file == "kkj") $namafile = 'Kartu Keluarga Jemaat';
        if($file == "baptis") $namafile = 'Baptis';
        if($file == "penyerahan") $namafile = 'Penyerahan';
        if($file == "pernikahan") $namafile = 'Pernikahan';

        // menyimpan output sementara di temp
        $pdfPath = sys_get_temp_dir() . "/Data $namafile.pdf";
        file_put_contents($pdfPath, $pdfOutput);
        
        // data yang akan di kirim ke attach email
        $dataPdf = [
            'pdfPath' => $pdfPath,
            'imagePath' => public_path('storage/'. $data->foto)
        ];
        
        Mail::send('emails.'.$file, ['dataPdf'=>$dataPdf, 'data'=> $data], function ($message) use ($pdfPath, $email, $namafile) {
            $message->to($email)
            ->subject("Data $namafile Gereja Bethel Indonesia")
            ->attach($pdfPath);
        });
        return "email send";
    }
}

if(! function_exists('create_form_pernikahan')){
    function create_form_pernikahan($req){
        $kkj = Kkj::where('kode', $req['search'])->first();

        $data = [
            "kkj_id" => $kkj->id,
            'email' => $req['email'],
            "waktu_pernikahan" => $req['waktu_pernikahan'],
            "tmpt_pernikahan" => $req['tmpt_pernikahan'],
            "alamat_setelah_menikah" => $req['alamat_setelah_menikah'],
            'status' => "waiting"
        ];
        $dataPernikahan = Pernikahan::create($data);

        // pengantin pria
        if(isset($req['pengantin_pria'])){
            $data_pria = [
                "pernikahan_id" => $dataPernikahan->id,
                "anggota_keluarga_id"=> $req['id'],
                "jk" => "pria",
                "no_kkj" => $req['no_kkj_pria'],
                "gereja" => $req['gereja_pria'],
                "no_ktp" => $req['no_ktp_pria'],
                "status_menikah" => $req['status_pernikahan_pria'],
                "alamat" => $req['alamat_pria'],
                "no_telp" => $req['no_telp_pria'],
            ];
        }else{
            $data_pria = [
                "pernikahan_id" => $dataPernikahan->id,
                "nama" => $req['nama_pria'],
                "jk" => "pria",
                "waktu_baptis" => Carbon::parse($req['waktu_baptis_pria'], "Asia/Jakarta"),
                "gereja" => $req['gereja_pria'],
                "no_kkj" => $req['no_kkj_pria'],
                "no_ktp" => $req['no_ktp_pria'],
                "tmpt_lahir" => $req['tmpt_lahir_pria'],
                "tgl_lahir" => Carbon::parse($req['tgl_lahir_pria'], 'Asia/Jakarta'),
                "status_menikah" => $req['status_pernikahan_pria'],
                "alamat" => $req['alamat_pria'],
                "no_telp" => $req['no_telp_pria'],
                "nama_ayah" => $req['nama_ayah_pria'],
                "nama_ibu" => $req['nama_ibu_pria'],
            ];
        }
        if(isset($req['foto_pria'])){
            $path = Storage::disk('public')->put('pernikahan', $req['foto_pria']);
            $data_pria['foto'] = $path;
        }
        $pria = Pengantin::create($data_pria);

        // pengantin wanita
        if(isset($req['pengantin_wanita'])){
            $data_wanita = [
                "pernikahan_id" => $dataPernikahan->id,
                "anggota_keluarga_id"=> $req['id'],
                "jk" => "wanita",
                "no_kkj" => $req['no_kkj_wanita'],
                "gereja" => $req['gereja_wanita'],
                "no_ktp" => $req['no_ktp_wanita'],
                "status_menikah" => $req['status_pernikahan_wanita'],
                "alamat" => $req['alamat_wanita'],
                "no_telp" => $req['no_telp_wanita'],
            ];
        }else{
            $data_wanita = [
                "pernikahan_id" => $dataPernikahan->id,
                "nama" => $req['nama_wanita'],
                "jk" => "wanita",
                "waktu_baptis" => Carbon::parse($req['waktu_baptis_wanita'], "Asia/Jakarta"),
                "gereja" => $req['gereja_wanita'],
                "no_kkj" => $req['no_kkj_wanita'],
                "no_ktp" => $req['no_ktp_wanita'],
                "tmpt_lahir" => $req['tmpt_lahir_wanita'],
                "tgl_lahir" => Carbon::parse($req['tgl_lahir_wanita'], 'Asia/Jakarta'),
                "status_menikah" => $req['status_pernikahan_wanita'],
                "alamat" => $req['alamat_wanita'],
                "no_telp" => $req['no_telp_wanita'],
                "nama_ayah" => $req['nama_ayah_wanita'],
                "nama_ibu" => $req['nama_ibu_wanita'],
            ];
        }
        if(isset($req['foto_wanita'])){
            $path = Storage::disk('public')->put('pernikahan', $req['foto_wanita']);
            $data_wanita['foto'] = $path;
        }
        $wanita = Pengantin::create($data_wanita);

        $dataPernikahan->kepala_keluarga = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'kepala keluarga' AND deleted_at is NULL")[0];
        $dataPernikahan->pasangan = DB::select("SELECT * FROM walis where kkj_id = $kkj->id AND status = 'pasangan' AND deleted_at is NULL")[0];
        $dataPernikahan->pengantin_pria = $pria;
        $dataPernikahan->pengantin_wanita = $wanita;
        $dataPernikahan->baptiss = Baptis::where('anggota_keluarga_id', $req['id'])->first();
        $dataPernikahan->kkj = $kkj;

        return $dataPernikahan;
    }
}

if(! function_exists('edit_form_pernikahan')){
    function edit_form_pernikahan($req, $id){
        $pria = Pengantin::find($req['pengantin_pria_id']);
        if($pria->anggota_keluarga){
            $data_pria = [
                "gereja" => $req['gereja_pria'],
                "no_ktp" => $req['no_ktp_pria'],
                "status_menikah" => $req['status_pernikahan_pria'],
                "alamat" => $req['alamat_pria'],
                "no_telp" => $req['no_telp_pria'],
            ];
        }else{
            $data_pria = [
                "nama" => $req['nama_pria'],
                "waktu_baptis" => Carbon::parse($req['waktu_baptis_pria'], "Asia/Jakarta"),
                "gereja" => $req['gereja_pria'],
                "no_kkj" => $req['no_kkj_pria'],
                "no_ktp" => $req['no_ktp_pria'],
                "tmpt_lahir" => $req['tmpt_lahir_pria'],
                "tgl_lahir" => Carbon::parse($req['tgl_lahir_pria'], 'Asia/Jakarta'),
                "status_menikah" => $req['status_pernikahan_pria'],
                "alamat" => $req['alamat_pria'],
                "no_telp" => $req['no_telp_pria'],
                "nama_ayah" => $req['nama_ayah_pria'],
                "nama_ibu" => $req['nama_ibu_pria'],
            ];
        }
        if(isset($req['foto_pria'])){
            if(Storage::disk('public')->exists("$pria->foto")){
                Storage::disk('public')->delete("$pria->foto");
            }
            $path = Storage::disk('public')->put('pernikahan', $req['foto_pria']);
            $data_pria['foto'] = $path;
        }
        $pria ->update($data_pria);

        // pengantin wanita
        $wanita = Pengantin::find($req['pengantin_wanita_id']);
        if($wanita->anggota_keluarga){
            $data_wanita = [
                "gereja" => $req['gereja_wanita'],
                "no_ktp" => $req['no_ktp_wanita'],
                "status_menikah" => $req['status_pernikahan_wanita'],
                "alamat" => $req['alamat_wanita'],
                "no_telp" => $req['no_telp_wanita'],
            ];
        }else{
            $data_wanita = [
                "nama" => $req['nama_wanita'],
                "waktu_baptis" => Carbon::parse($req['waktu_baptis_wanita'], "Asia/Jakarta"),
                "gereja" => $req['gereja_wanita'],
                "no_kkj" => $req['no_kkj_wanita'],
                "no_ktp" => $req['no_ktp_wanita'],
                "tmpt_lahir" => $req['tmpt_lahir_wanita'],
                "tgl_lahir" => Carbon::parse($req['tgl_lahir_wanita'], 'Asia/Jakarta'),
                "status_menikah" => $req['status_pernikahan_wanita'],
                "alamat" => $req['alamat_wanita'],
                "no_telp" => $req['no_telp_wanita'],
                "nama_ayah" => $req['nama_ayah_wanita'],
                "nama_ibu" => $req['nama_ibu_wanita'],
            ];
        }
        if(isset($req['foto_wanita'])){
            if(Storage::disk('public')->exists("$wanita->foto")){
                Storage::disk('public')->delete("$wanita->foto");
            }
            $path = Storage::disk('public')->put('pernikahan', $req['foto_wanita']);
            $data_wanita['foto'] = $path;
        }
        $wanita->update($data_wanita);

        // data pernikahan
        $dataPernikahan = Pernikahan::find($id);
        $data = [
            'email' => $req['email'],
            "waktu_pernikahan" => $req['waktu_pernikahan'],
            "tmpt_pernikahan" => $req['tmpt_pernikahan'],
            "alamat_setelah_menikah" => $req['alamat_setelah_menikah'],
        ];
        $dataPernikahan->update($data);

        return Pernikahan::find($id);
    }
}