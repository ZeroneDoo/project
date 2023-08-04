<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Baptis;
use App\Models\Kkj;
use App\Models\Penyerahan;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role->nama == "Admin Kartu Keluarga"){
            $datas = Kkj::where("status", "waiting")->paginate(4);
        }elseif(Auth::user()->role->nama == "Admin Baptis"){
            $datas = Baptis::with('anggota_keluarga')->where("status", "waiting")->paginate(4);
        }elseif(Auth::user()->role->nama == "Admin Penyerahan"){
            $datas = Penyerahan::with('anggota_keluarga')->where("status", "waiting")->paginate(4);
        }elseif (Auth::user()->role->nama == "Admin Pernikahan"){
            $datas = Pernikahan::with('pengantin', 'pengantin.anggota_keluarga')->where('status', "waiting")->paginate(4);
        }

        return view("dashboard", compact('datas'));
    }
}
