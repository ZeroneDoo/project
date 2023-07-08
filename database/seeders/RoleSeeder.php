<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            "Admin Baptis",
            "Admin Penyerahan Anak",
            "Admin Kartu Keluarga",
            "Admin Pernikahan",
            "Admin Doa",
        ];

        foreach($datas as $data) {
            Role::create(['nama' => $data]);
        }
    }
}
