<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice as Invoices;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class TrialController extends Controller
{
    public function coba(){
        $invoices = Invoices::query()
            ->where('bulan', '=', 7)
            ->where('tahun', '=', 2022)
            ->get();
//        $invoices = Invoices::all();

        $data = [];
        foreach ($invoices as $invoice){
            $id = $invoice->id_invoice;
            $pelanggan_id = $invoice->pelanggan_id;
            $totalinv = $invoice->harga_bayar;
            $tagihan = $invoice->tagihan;
            $tgl_terbit = $invoice->tgl_terbit;
            $tgl_bayar = $invoice->tgl_bayar;
            $tgl_tempo = $invoice->tgl_tempo;
            $stat = $invoice->status_id;
            $statu = Status::query()->find($stat);
            $status = $statu->nama_status;

            $pelanggan = User::query()->find($pelanggan_id);
            $nama = $pelanggan->name;
            $data[] = [
                'Id Invoice' => $id,
                'Nama Pelanggan' => $nama,
                'Total Harga Invoice' => $totalinv,
                'Total Tagihan' => $tagihan,
                'Tanggal Terbit' => $tgl_terbit,
                'Tanggal Tempo' => $tgl_tempo,
                'Tanggal Bayar' => $tgl_bayar,
                'Status' => $status,
            ];
        }
        dd($data);
    }
}
