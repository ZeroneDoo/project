<?php

namespace Database\Seeders;

use App\Models\{
    AnggotaKeluarga,
    Kkj,
    KkjAnak,
    KkjKepalaKeluarga,
    KkjPasangan,
    Urgent,
    Wali,
};
use Illuminate\Database\Seeder;

class KkjSeeder extends Seeder
{
    public function run()
    {
        $code = generateCode();
        $dataKkj = [
            "kode" => $code,
            "nama_kepala_keluarga" => "Kevin",
            "email" => "rizqipambudi6@gmail.com",
            "jk" => "L",
            "alamat" => "-",
            "rt_rw" => "-",
            "telp" => "0824394",
            "provinsi" => "Jawa Barat",
            "kabupaten" => "Kota Depok",
            "kecamatan" => "Sukma Jaya",
            "status_menikah" => "Sudah Menikah",
            "cabang" => "Jakarta"
        ];

        $kkj = Kkj::create($dataKkj);

        // kepala keluarga
        $dataKepalaKeluarga = [
            "kkj_id" => $kkj->id,
            "nama" => "Kevin",
            "jk" => "L",
            "tmpt_lahir" => "Depok",
            "tgl_lahir" => "2023-07-07",
            "pendidikan_terakhir" => 'SMA',
            "pekerjaan" => "Buruh",
            "baptis" => "2023-07-07",
            "status" => "kepala keluarga"
        ];

        Wali::create($dataKepalaKeluarga);
        
        // pasangan
        $dataPasangan = [
            "kkj_id" => $kkj->id,
            "nama" => "Christina",
            "jk" => "P",
            "tmpt_lahir" => "Depok",
            "tgl_lahir" => "2023-07-07",
            "pendidikan_terakhir" => "SMK",
            "pekerjaan" => "PNS",
            "baptis" => "2023-07-07",
            "status" => "pasangan"
        ];

         Wali::create($dataPasangan);

        $dataAnak = [
            "kkj_id" => $kkj->id,
            "nama" => "Angelina",
            "jk" => "P",
            "tmpt_lahir" => "Jakarta",
            "tgl_lahir" => "2023-07-07",
            "pendidikan" => "SMA",
            "pekerjaan" => "-",
            "diserahkan" => "T",
            "baptis" => "T",
            "nikah" => "T",
            "hubungan" => 'Anak'
        ];
        
        AnggotaKeluarga::create($dataAnak);
         // urgent
        $dataUrgent = [
            'kkj_id' => $kkj->id,
            'nama' => "Agung",
            'alamat' => "-",
            'telp' => "012391",
            'hubungan' => "Paman",
        ];

        Urgent::create($dataUrgent);
    }
}
