<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                "role_id" => 1,
                "nama" => "Super Admin",
                "email" => "superadmin@gmail.com",
                "password" => Hash::make("password"),
                "nip" => 123123
            ],
            [
                "role_id" => 2,
                "nama" => "Baptis",
                "email" => "baptis@gmail.com",
                "password" => Hash::make("password"),
                "nip" => 12312231
            ],
            [
                "role_id" => 3,
                "nama" => "Penyerahan",
                "email" => "penyerahan@gmail.com",
                "password" => Hash::make("password"),
                "nip" => 12312231321
            ],
            [
                "role_id" => 4,
                "nama" => "Kartu Keluarga",
                "email" => "kkj@gmail.com",
                "password" => Hash::make("password"),
                "nip" => 12312231123
            ],
            [
                "role_id" => 5,
                "nama" => "Pernikahan",
                "email" => "pernikahan@gmail.com",
                "password" => Hash::make("password"),
                "nip" => 1231223112312
            ],
        ];

        foreach($datas as $data){
            User::create($data);
        }
    }
}
