<?php

use App\Models\{
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
};
use Carbon\Carbon;
use Illuminate\Support\Facades\{
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
            "cabang" => "Jakarta"
        ];

        // foto
        if(isset($request['foto'])){
            $path = Storage::disk("public")->put("kkj", $request['foto']);
            $dataKkj['foto'] = $path;
        }

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
            ];

            $request['status_menikah'] == "Sudah Menikah" ? KkjPasangan::create($dataPasangan) : null;
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
                ];
                
                KkjAnak::create($dataAnak);
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
    
                KkjKeluarga::create($dataKeluarga);
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

        return Kkj::with('kkj_kepala_keluarga','kkj_pasangan', 'kkj_anak', 'kkj_keluarga')->find($kkj->id);
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

        // foto
        if(isset($req['foto'])){
            $path = Storage::disk("public")->put("kkj", $req['foto']);
            $dataKkj['foto'] = $path;
        }

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
        if(isset($req['pasangan'])){
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
                    "hubungan" => $req["hubungan_keluargas"][$i],
                ];
                
                KkjKeluarga::create($dataKeluarga);
            }
        }
        // keluarga edit
        if(isset($req["id_keluarga"])){
            foreach ($req["id_keluarga"] as $i => $keluarga) {
                foreach($req['hubungan_keluarga_edit'] as $hubungan){
                    if($hubungan != null) $req['hubungan_keluargas_edit'][] = $hubungan;
                }
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
                    "hubungan" => $req["hubungan_keluargas_edit"][$i],
                ];
                
                $kkjKeluarga->update($dataKeluarga);
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

        return Kkj::with('kkj_kepala_keluarga','kkj_pasangan', 'kkj_anak', 'kkj_keluarga')->find($idkkj);
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
        try {
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
        } catch (\Throwable $th) {
            return back()->with('msg_info', 'Info pesan email tidak terkirim');
        }
    }
}

if(! function_exists('create_form_pernikahan')){
    function create_form_pernikahan($req){
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
            "jk_pengantin" => "Pria"
        ];
        if(isset($req['foto_pria'])){
            $path = Storage::disk('public')->put('pernikahan', $req['foto_pria']);
            $data_pria['foto'] = $path;
        }
        $pria = Pengantin::create($data_pria);

        // pengantin wanita
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
            "jk_pengantin" => "Wanita"
        ];
        if(isset($req['foto_wanita'])){
            $path = Storage::disk('public')->put('pernikahan', $req['foto_wanita']);
            $data_wanita['foto'] = $path;
        }
        $wanita = Pengantin::create($data_wanita);

        $data = [
            "pengantin_pria_id" => $pria->id,
            "pengantin_wanita_id" => $wanita->id,
            'email' => $req['email'],
            "waktu_pernikahan" => $req['waktu_pernikahan'],
            "tmpt_pernikahan" => $req['tmpt_pernikahan'],
            "alamat_setelah_menikah" => $req['alamat_setelah_menikah'],
        ];
        $dataPernikahan = Pernikahan::create($data);

        if($req['hubungan'] =="anak"){
            $anggotakeluarga = KkjAnak::find($req['id']);
        }else if($req['hubungan'] == "keluarga"){
            $anggotakeluarga = KkjKeluarga::find($req['id']);
        }

        $anggotakeluarga->update(['nikah' => "Y"]);

        return Pernikahan::with('pengantin')->find($dataPernikahan->id);
    }
}

if(! function_exists('edit_form_pernikahan')){
    function edit_form_pernikahan($req, $id){
        $pria = Pengantin::find($req['pengantin_pria_id']);
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

        return Pernikahan::with('pengantin')->find($id);
    }
}