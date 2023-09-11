<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\CabangIbadah;
use App\Models\Kegiatan;
use App\Models\PendetaCabang;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "nama" => "Cabang 1",
                "alamat" => "Jl. Jakarta Raya",
                "deskripsi" => "Gereja Bethel Cabang 1",
            ],
            [
                "nama" => "Cabang 2",
                "alamat" => "Jl. Jakarta Raya 2",
                "deskripsi" => "Gereja Bethel Cabang 2",
            ]
        ];

        foreach($datas as $data) {
            $cabang = Cabang::create($data);

            $pendetas = [
                [
                    'cabang_id' => $cabang->id,
                    'pendeta' => "Kevin"
                ],
                [
                    'cabang_id' => $cabang->id,
                    'pendeta' => "Kevan"
                ]
            ];

            foreach($pendetas as $pendeta) {
                PendetaCabang::create($pendeta);
            }

            $jadwal_ibadahs = [
                [
                    "cabang_id" => $cabang->id,
                    "hari" => "Minggu",
                    "waktu" => Carbon::now("Asia/Jakarta")
                ]
            ];

            foreach($jadwal_ibadahs as $jadwal_ibadah) {
                CabangIbadah::create($jadwal_ibadah);
            }

            $kegiatans = [
                [
                    "cabang_id" => $cabang->id,
                    "pendeta" => "Kevin & Malik",
                    "nama" => "Cool (Community Of Life)",
                    "area" => "Taman Gereja Bethel",
                    "waktu" => Carbon::now("Asia/Jakarta")
                ]
            ];

            
            foreach($kegiatans as $kegiatan) {
                Kegiatan::create($kegiatan);
            }
        }

    }
}
