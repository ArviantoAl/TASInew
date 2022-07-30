<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $bulannow=Carbon::now()->format('n');
        $bulan2=Carbon::now()->format('F');
        $tahunnow=Carbon::now()->format('Y');

        $selected = $bulan2;
        $selected2 = $tahunnow;

        $getall = Invoice::query()->orderBy('tgl_terbit', 'DESC')->get();
        $databulan = $getall->groupBy(function ($getall){
            return Carbon::parse($getall->tgl_terbit)->format('F');
        });
        $valbulan = $getall->groupBy(function ($getall){
            return Carbon::parse($getall->tgl_terbit)->format('n');
        });
        $datatahun = $getall->groupBy(function ($getall){
            return Carbon::parse($getall->tgl_terbit)->format('Y');
        });

        $bulan = [];
        $vabulan = [];
        $tahun = [];
        foreach ($databulan as $nbulan => $values){
            $bulan[] = $nbulan;
        }
        foreach ($valbulan as $vbulan => $values){
            $vabulan[] = $vbulan;
        }
        foreach ($datatahun as $ntahun => $values){
            $tahun[] = $ntahun;
        }

        $invoice = Invoice::query()
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->get();
        $terbayar = Invoice::query()
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->get();
        $belumbayar = Invoice::query()
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->where('status_id', '=', 6)
            ->get();
        $tidakbayar = Invoice::query()
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->where('status_id', '=', 9)
            ->get();

        $total = DB::table('invoices')
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->sum('harga_bayar');
        $bel = DB::table('invoices')
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->sum('tagihan');
        $ter = DB::table('invoices')
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->sum('harga_bayar');
        $bat = DB::table('invoices')
            ->where('bulan', '=', $bulannow)
            ->where('tahun', '=', $tahunnow)
            ->where('status_id', '=', 9)
            ->sum('harga_bayar');

        $h_invoice = count($invoice);
        $h_terbayar = count($terbayar);
        $h_belumbayar = count($belumbayar);
        $h_tidakbayar = count($tidakbayar);

        if (auth()->user()->user_role==1){
            return view('dashboard.admin.index', compact('h_invoice','h_terbayar','h_belumbayar','h_tidakbayar',
                'bulan','vabulan','tahun','selected','selected2','total','bel','ter','bat'));
        }elseif(auth()->user()->user_role==2){
            return view('dashboard.teknisi.index');
        }elseif(auth()->user()->user_role==3){
            return view('dashboard.pelanggan.index');
        }
    }

    //getajax
    public function get_ainv(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $invoice = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->get();
        $terbayar = Invoice::query()
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->get();
        $belumbayar = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 6)
            ->get();
        $tidakbayar = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 9)
            ->get();

        $total = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('harga_bayar');
        $bel = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('tagihan');
        $ter = DB::table('invoices')
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('harga_bayar');
        $bat = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 9)
            ->sum('harga_bayar');

        $h_invoice = count($invoice);
        $h_terbayar = count($terbayar);
        $h_belumbayar = count($belumbayar);
        $h_tidakbayar = count($tidakbayar);

        return response()->json([
            'h_invoice'=>$h_invoice,
            'h_terbayar'=>$h_terbayar,
            'h_belumbayar'=>$h_belumbayar,
            'h_tidakbayar'=>$h_tidakbayar,
            'total'=>$total,
            'ter'=>$ter,
            'bel'=>$bel,
            'bat'=>$bat,
        ]);
    }
    public function get_binv(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $invoice = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->get();
        $terbayar = Invoice::query()
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->get();
        $belumbayar = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 6)
            ->get();
        $tidakbayar = Invoice::query()
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 9)
            ->get();

        $total = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('harga_bayar');
        $bel = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('tagihan');
        $ter = DB::table('invoices')
            ->where('status_id', '=', 7)
            ->orWhere('status_id', '=', 8)
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->sum('harga_bayar');
        $bat = DB::table('invoices')
            ->where('bulan', '=', $bulan)
            ->where('tahun', '=', $tahun)
            ->where('status_id', '=', 9)
            ->sum('harga_bayar');

        $h_invoice = count($invoice);
        $h_terbayar = count($terbayar);
        $h_belumbayar = count($belumbayar);
        $h_tidakbayar = count($tidakbayar);

        return response()->json([
            'h_invoice'=>$h_invoice,
            'h_terbayar'=>$h_terbayar,
            'h_belumbayar'=>$h_belumbayar,
            'h_tidakbayar'=>$h_tidakbayar,
            'total'=>$total,
            'ter'=>$ter,
            'bel'=>$bel,
            'bat'=>$bat,
        ]);
    }
}
