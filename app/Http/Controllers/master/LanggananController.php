<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LanggananController extends Controller
{
    public function semua_langganan(){
        if(auth()->user()->user_role==3){
            $user = Auth::user()->id_user;
            $langganans = Langganan::query()->where('pelanggan_id', $user)->paginate(10);
        }else{
            $langganans = Langganan::query()->paginate(10);
        }
        $today = Carbon::today()->setTimezone('Asia/Jakarta');
        $header = 'Semua Langganan';

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.langganan', compact('langganans', 'today', 'header'));
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.langganan', compact('langganans', 'today', 'header'));
        }
    }
}
