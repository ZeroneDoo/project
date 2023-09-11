<?php

namespace Database\Seeders;

use App\Models\Pendeta;
use Illuminate\Database\Seeder;

class PendetaSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            [
                "nama" => "Gabriel"
            ],
            [
                "nama" => "Gabrieloni"
            ],
        ];

        foreach($datas as $data){
            Pendeta::create($data);
        }
    }
}
