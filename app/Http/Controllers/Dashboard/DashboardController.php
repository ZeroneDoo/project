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
        $datas = Kkj::where("status", "waiting")->paginate(4);
        if(Auth::user()->role->nama == "Admin Kartu Keluarga") $datas = Kkj::where("cabang_id", Auth::user()->cabang_id)->where("status", "waiting")->paginate(4);
        $jmlKKJ = Kkj::count();

        return view("superadmin.index", compact('datas','jmlKKJ'));
    }
}
