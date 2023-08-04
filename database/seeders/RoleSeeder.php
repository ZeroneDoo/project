<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            "Super Admin",
            "Admin Baptis",
            "Admin Penyerahan",
            "Admin Kartu Keluarga",
            "Admin Pernikahan",
            "Admin Doa",
        ];

        foreach($datas as $data) {
            Role::create(['nama' => $data]);
        }
    }
}
