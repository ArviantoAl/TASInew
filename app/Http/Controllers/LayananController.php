<?php

namespace App\Http\Controllers;

use App\Models\Bts;
use App\Models\Kategori;
use App\Models\Langganan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function index_layanan(){
        $layanans = Layanan::query()->paginate(10);

        return view('dashboard.admin.layanan.layanan', compact('layanans'));
    }

    public function tambah_layanan(){
        $layanan = new Layanan();

        return view('dashboard.admin.layanan.tambah_layanan', compact('layanan'));
    }

    public function post_tambah_layanan(Request $request){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
        ]);

        $layanan = new Layanan();
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;
        $layanan->status_id = 3;

        $layanan->save();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil ditambahkan.');
    }

    public function edit_layanan($id_layanan){
        $layanan = Layanan::find($id_layanan);

        return view('dashboard.admin.layanan.edit_layanan', compact('layanan'));
    }

    public function post_edit_layanan(Request $request ,$id_layanan){
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
        ]);

        $layanan = Layanan::find($id_layanan);
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga = $request->harga;

        $layanan->save();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil diubah.');
    }

    public function nonaktif_layanan($id_layanan)
    {
        $layanan = Layanan::find($id_layanan);
        $nama = $layanan->nama_layanan;
        $layanan->status_id = 4;
        $layanan->save();

        return back()->with('success', 'Layanan '.$nama.' telah dinonaktifkan!');
    }

    public function aktif_layanan($id_layanan)
    {
        $layanan = Layanan::find($id_layanan);
        $layanan->status_id = 3;
        $layanan->save();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil diaktifkan.');
    }

    public function destroy($id_layanan)
    {
        $layanans = Layanan::find($id_layanan);
        $langganan = Langganan::query()->where('layanan_id','=',$id_layanan)->get();
        foreach ($langganan as $lang){
            $id_langganan = $lang->id_langganan;
            DB::table('turunan_bts')
                ->where('langganan_id', '=', $id_langganan)
                ->delete();
        }

        $layanans->delete();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil dihapus.');
    }

    public function destroy_lang($id_langganan)
    {
        $langganan = Langganan::find($id_langganan);

        DB::table('turunan_bts')
            ->where('langganan_id', '=', $id_langganan)
            ->delete();

        $langganan->delete();

        return redirect()->route('admin.layanan')
            ->with('success','Layanan berhasil dihapus.');
    }
}
