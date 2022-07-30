<?php

namespace App\Http\Controllers;

use App\Mail\MailAdmins;
use App\Mail\Invoice as Invoices;
use App\Models\Bts;
use App\Models\District;
use App\Models\Invoice;
use App\Models\Langganan;
use App\Models\Langinv;
use App\Models\Layanan;
use App\Models\Ppn;
use App\Models\Province;
use App\Models\Regency;
use App\Models\TurunanBts;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function pemesanan(){
        $user = User::query()->where('user_role', '=', 3)
            ->where('status_id', '=', 3)
            ->orWhere('status_id', '=', 2)
            ->get();
        $layanan = Layanan::query()->where('status_id', '=', 3)->get();
        $provinsi = Province::all();
        $bts = Bts::query()->where('status_id', '=', 3)->get();
        return view('dashboard.admin.pemesanan.pemesanan', compact('user', 'layanan', 'provinsi', 'bts'));
    }

    public function pelanggan_baru(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);
        $name = $request->name;
        $username = $request->username;
        $password = Hash::make($username);
        $email = $request->email;
        $flag_ppn = $request->ppn;
        $layanan_id = $request->id_layanan;
        $provinsi_id = $request->id_provinsi;
        $kabupaten_id = $request->id_kabupaten;
        $kecamatan_id = $request->id_kecamatan;
        $desa_id = $request->id_desa;
        $bts_id = $request->id_bts;

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('email','=',$email)
            ->where('username','=',$username)
            ->get();

        $getemail = User::query()
            ->where('email','=',$email)
            ->get();
        $getusername = User::query()
            ->where('username','=',$username)
            ->get();

        $tahun = Carbon::now()->format('Y');
        $getppn = Ppn::query()
            ->where('tahun','=',$tahun)
            ->get()
            ->toArray();
        $objectToArray = (array)$getppn;
        $ppn1 = $objectToArray[0];
        $ppn2 = (array)$ppn1;
        $jppn = $ppn2['jumlah'];
        if (count($getppn)!=0){
            if ($flag_ppn == 1){
                $hppn = '1';
            }else{
                $hppn = '0';
            }
        }else{
            $hppn = '0';
        }

        if (count($getpelanggan_id)>0){
            return response()->json(['cek'=>0, 'msg'=>'Bukan pelanggan baru!']);
        }elseif(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }elseif(count($getusername)>0){
            return response()->json(['cek'=>2, 'msg'=>'No Hp sudah terpakai!']);
        }elseif ($layanan_id==0){
            return response()->json(['cek'=>3, 'msg'=>'Layanan Belum Dipilih!']);
        }elseif ($bts_id==0){
            return response()->json(['cek'=>4, 'msg'=>'BTS Belum Dipilih!']);
        }elseif ($provinsi_id==0){
            return response()->json(['cek'=>5, 'msg'=>'Data Provinsi Belum Dipilih!']);
        }elseif ($kabupaten_id==0){
            return response()->json(['cek'=>6, 'msg'=>'Data Kabupaten Belum Dipilih!']);
        }elseif ($kecamatan_id==0){
            return response()->json(['cek'=>7, 'msg'=>'Data Kecamatan Belum Dipilih!']);
        }elseif ($desa_id==0){
            return response()->json(['cek'=>8, 'msg'=>'Data Desa Belum Dipilih!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->status_id = 2;
            $user->ppn = $hppn;
            $nama_role = 'Pelanggan';
            $user->save();

            $data_ambil = [
                'nama' => $name,
                'nama_role' => $nama_role,
                'username' => $username,
                'email' => $email,
                'password' => $username,
            ];

            Mail::to($email)->send(new MailAdmins($data_ambil));

            $detail_alamat = $request->id_alamat;
            $lokasi = $request->lokasi;
            $ll = explode(",",$lokasi);
            $long = $ll[1];
            $lat = $ll[0];

            $getturunan = $request->id_turunan;
            if ($getturunan==0){
                $turunan_id = null;
            }else{
                $turunan_id = $getturunan;
            }
            $ip = $request->ip;
            $ip_radio = $request->ip_radio;

            $getlayanan = Layanan::query()->find($layanan_id);
            $harga = $getlayanan->harga;

            $getpelanggan_id2 = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
                ->where('status_id', '=', 2)
                ->get()
                ->toArray();
            $objectToArray = (array)$getpelanggan_id2;
            $pel1 = $objectToArray[0];
            $pel2 = (array)$pel1;
            $pelanggan_id = $pel2['id_user'];

            $langganan = new Langganan();
            $langganan->pelanggan_id = $pelanggan_id;
            $langganan->layanan_id = $layanan_id;
            $langganan->provinsi_id = $provinsi_id;
            $langganan->kabupaten_id = $kabupaten_id;
            $langganan->kecamatan_id = $kecamatan_id;
            $langganan->desa_id = $desa_id;
            $langganan->detail_alamat = $detail_alamat;
            $langganan->bts_id = $bts_id;
            $langganan->turunan_id = $turunan_id;
            $langganan->ip = $ip;
            $langganan->longitude = $long;
            $langganan->latitude = $lat;
            $langganan->ip_radio = $ip_radio;

            $getprovinsi = Province::query()->find($provinsi_id);
            $provinsi = $getprovinsi->name;

            $getkabupaten = Regency::query()->find($kabupaten_id);
            $kabupaten = $getkabupaten->name;

            $getkecamatan = District::query()->find($kecamatan_id);
            $kecamatan = $getkecamatan->name;

            $getdesa = Village::query()->find($desa_id);
            $desa = $getdesa->name;

            $alamat = $detail_alamat;
            $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
            $langganan->alamat_pasang = implode(", ",$lengkap);
            $langganan->status_id = 2;
            $langganan->save();

            $getlangganan_id = Langganan::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('layanan_id', '=', $layanan_id)
                ->where('ip', '=', $ip)
                ->where('ip_radio', '=', $ip_radio)
                ->where('status_id', '=', 2)
                ->get()
                ->toArray();
            $objectToArray = (array)$getlangganan_id;
            $lang1 = $objectToArray[0];
            $lang2 = (array)$lang1;
            $langganan_id = $lang2['id_langganan'];

            $huruf = 'INV';
            $acak1 = rand(10, 99);
            $acak2 = rand(10, 99);
            $bulan=Carbon::now()->format('n');
            $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan,$tahun);
            $id_invoice = implode($lengkap);

            $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

            if ($hppn=='1'){
                $getppn2 = $jppn;
            }else{
                $getppn2 = 0;
            }
            $hargappn = $harga*$getppn2/100;
            $harga2 = $harga+$hargappn;

            $invoice = new Invoice();
            $invoice->id_invoice = $id_invoice;
            $invoice->pelanggan_id = $pelanggan_id;
            $invoice->harga_bayar = $harga2;
            $invoice->tagihan = $harga2;
            $invoice->tgl_terbit = $tgl_terbit;
            $invoice->bulan = $bulan;
            $invoice->tahun = $tahun;
            $invoice->ppn = $getppn2;
            $invoice->status_id = 6;
            $invoice->save();

            $langinv = new Langinv();
            $langinv->invoice_id = $id_invoice;
            $langinv->pelanggan_id = $pelanggan_id;
            $langinv->layanan_id = $layanan_id;
            $langinv->harga_satuan = $harga;
            $langinv->langganan_id = $langganan_id;
            $langinv->status_id = 6;
            $langinv->save();

            $langganans = Langinv::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('invoice_id', '=', $id_invoice)
                ->where('status_id', '=', 6)
                ->get();

            $data_ambil = [
                'email_cv' => 'info@gudangtechno.web.id',
                'nama_pelanggan' => $name,
                'email_pelanggan' => $email,
                'no_hp_pelanggan' => $username,
                'id_invoice' => $id_invoice,
                'tgl_terbit' => $tgl_terbit,
                'harga_bayar' => $harga2,
                'langganans' => $langganans,
                'subtotal' => $harga,
                'ppn' => $getppn2,
                'hargappn' => $hargappn,
            ];

            Mail::to($email)->send(new Invoices($data_ambil));

            return redirect()->route('admin.invoice')
                ->with('success','Invoice Terkirim.');
        }
    }

    public function form_lama($id_user){
        $user = User::query()->find($id_user);
        $layanan = Layanan::query()->where('status_id', '=', 3)->get();
        $provinsi = Province::all();
        $bts = Bts::query()->where('status_id', '=', 3)->get();
        return view('dashboard.admin.pemesanan.tambah', compact('user', 'layanan', 'provinsi', 'bts'));
    }

    public function pelanggan_lama(Request $request){

        $layanan_id = $request->layanan;
        $provinsi_id = $request->provinsi;
        $kabupaten_id = $request->kabupaten;
        $kecamatan_id = $request->kecamatan;
        $desa_id = $request->desa;
        $bts_id = $request->bts;

        if ($layanan_id==0){
            return response()->json(['status'=>0, 'msg'=>'Layanan Belum Dipilih!']);
        }elseif ($bts_id==0){
            return response()->json(['status'=>1, 'msg'=>'BTS Belum Dipilih!']);
        }elseif ($provinsi_id==0){
            return response()->json(['status'=>2, 'msg'=>'Data Provinsi Belum Dipilih!']);
        }elseif ($kabupaten_id==0){
            return response()->json(['status'=>3, 'msg'=>'Data Kabupaten Dipilih!']);
        }elseif ($kecamatan_id==0){
            return response()->json(['status'=>4, 'msg'=>'Data Kecamatan Dipilih!']);
        }elseif ($desa_id==0){
            return response()->json(['status'=>5, 'msg'=>'Data Desa Dipilih!']);
        }else{
            $pelanggan_id = $request->id_user;
            $detail_alamat = $request->id_alamat;
            $lokasi = $request->lokasi;
            $ll = explode(",",$lokasi);
            $long = $ll[1];
            $lat = $ll[0];
            $getturunan = $request->id_turunan;
            if ($getturunan==0){
                $turunan_id = null;
            }else{
                $turunan_id = $getturunan;
            }
            $ip = $request->ip;
            $ip_radio = $request->ip_radio;

            $getlayanan = Layanan::query()->find($layanan_id);
            $harga = $getlayanan->harga;

            $langganan = new Langganan();
            $langganan->pelanggan_id = $pelanggan_id;
            $langganan->layanan_id = $layanan_id;
            $langganan->provinsi_id = $provinsi_id;
            $langganan->kabupaten_id = $kabupaten_id;
            $langganan->kecamatan_id = $kecamatan_id;
            $langganan->desa_id = $desa_id;
            $langganan->detail_alamat = $detail_alamat;
            $langganan->bts_id = $bts_id;
            $langganan->turunan_id = $turunan_id;
            $langganan->ip = $ip;
            $langganan->longitude = $long;
            $langganan->latitude = $lat;
            $langganan->ip_radio = $ip_radio;

            $getprovinsi = Province::query()->find($provinsi_id);
            $provinsi = $getprovinsi->name;

            $getkabupaten = Regency::query()->find($kabupaten_id);
            $kabupaten = $getkabupaten->name;

            $getkecamatan = District::query()->find($kecamatan_id);
            $kecamatan = $getkecamatan->name;

            $getdesa = Village::query()->find($desa_id);
            $desa = $getdesa->name;

            $alamat = $detail_alamat;
            $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
            $langganan->alamat_pasang = implode(", ",$lengkap);
            $langganan->status_id = 2;
            $langganan->save();

            $getlangganan_id = Langganan::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('layanan_id', '=', $layanan_id)
                ->where('ip', '=', $ip)
                ->where('ip_radio', '=', $ip_radio)
                ->where('status_id', '=', 2)
                ->get()
                ->toArray();
            $objectToArray = (array)$getlangganan_id;
            $lang1 = $objectToArray[0];
            $lang2 = (array)$lang1;
            $langganan_id = $lang2['id_langganan'];

            $bulan=Carbon::now()->format('n');
            $tahun=Carbon::now()->format('Y');
            $cekinvoice = Invoice::query()
                ->where('pelanggan_id', '=', $pelanggan_id)
                ->where('status_id', '=', 6)
                ->where('bulan', '=', $bulan)
                ->where('tahun', '=', $tahun)
                ->get();

            $user = User::query()->find($pelanggan_id);
            $name = $user->name;
            $email = $user->email;
            $username = $user->username;
            $hppn = $user->ppn;

            $getppn = Ppn::query()
                ->where('tahun','=',$tahun)
                ->get()
                ->toArray();
            $objectToArray = (array)$getppn;
            $ppn1 = $objectToArray[0];
            $ppn2 = (array)$ppn1;
            $jppn = $ppn2['jumlah'];

            if ($hppn=='1'){
                $getppn2 = $jppn;
            }else{
                $getppn2 = 0;
            }

            if (count($cekinvoice)==0){
                $huruf = 'INV';
                $acak1 = rand(10, 99);
                $acak2 = rand(10, 99);
                $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan,$tahun);
                $id_invoice = implode($lengkap);

                $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

                $hargappn = $harga*$getppn2/100;
                $harga2 = $harga+$hargappn;

                $invoice = new Invoice();
                $invoice->id_invoice = $id_invoice;
                $invoice->pelanggan_id = $pelanggan_id;
                $invoice->harga_bayar = $harga2;
                $invoice->tagihan = $harga2;
                $invoice->tgl_terbit = $tgl_terbit;
                $invoice->bulan = $bulan;
                $invoice->tahun = $tahun;
                $invoice->ppn = $getppn2;
                $invoice->status_id = 6;
                $invoice->save();

                $langinv = new Langinv();
                $langinv->invoice_id = $id_invoice;
                $langinv->pelanggan_id = $pelanggan_id;
                $langinv->layanan_id = $layanan_id;
                $langinv->harga_satuan = $harga;
                $langinv->langganan_id = $langganan_id;
                $langinv->status_id = 6;
                $langinv->save();

                $langganans = Langinv::query()
                    ->where('pelanggan_id', '=', $pelanggan_id)
                    ->where('invoice_id', '=', $id_invoice)
                    ->where('status_id', '=', 6)
                    ->get();

                $data_ambil = [
                    'email_cv' => 'info@gudangtechno.web.id',
                    'nama_pelanggan' => $name,
                    'email_pelanggan' => $email,
                    'no_hp_pelanggan' => $username,
                    'id_invoice' => $id_invoice,
                    'tgl_terbit' => $tgl_terbit,
                    'harga_bayar' => $harga2,
                    'langganans' => $langganans,
                    'subtotal' => $harga,
                    'ppn' => $getppn2,
                    'hargappn' => $hargappn,
                ];

                Mail::to($email)->send(new Invoices($data_ambil));
            }else{
                $getinvoice = Invoice::query()
                    ->where('pelanggan_id', '=', $pelanggan_id)
                    ->where('bulan', '=', $bulan)
                    ->where('tahun', '=', $tahun)
                    ->get()
                    ->toArray();
                $objectToArray = (array)$getinvoice;
                $inv1 = $objectToArray[0];
                $inv2 = (array)$inv1;
                $id_inv = $inv2['id_invoice'];

                $langinv = new Langinv();
                $langinv->invoice_id = $id_inv;
                $langinv->pelanggan_id = $pelanggan_id;
                $langinv->layanan_id = $layanan_id;
                $langinv->harga_satuan = $harga;
                $langinv->langganan_id = $langganan_id;
                $langinv->status_id = 6;
                $langinv->save();

                $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

                $gettagihan = DB::table('langganan_invoices')
                    ->where('pelanggan_id', '=', $pelanggan_id)
                    ->where('invoice_id', '=', $id_inv)
                    ->where('status_id', '=', 6)
                    ->sum('harga_satuan');

                $hargappn2 = $gettagihan*$getppn2/100;
                $hgettagihan = $gettagihan+$hargappn2;

                DB::table('invoices')
                    ->where('id_invoice', $id_inv)
                    ->update([
                        'harga_bayar' => $hgettagihan,
                        'tagihan' => $hgettagihan,
                        'tgl_terbit' => $tgl_terbit,
                        'tgl_tempo' => null,
                        'status_id' => 6
                    ]);

                $langganans = Langinv::query()
                    ->where('pelanggan_id', '=', $pelanggan_id)
                    ->where('invoice_id', '=', $id_inv)
                    ->get();

                $data_ambil = [
                    'email_cv' => 'info@gudangtechno.web.id',
                    'nama_pelanggan' => $name,
                    'email_pelanggan' => $email,
                    'no_hp_pelanggan' => $username,
                    'id_invoice' => $id_inv,
                    'tgl_terbit' => $tgl_terbit,
                    'harga_bayar' => $hgettagihan,
                    'langganans' => $langganans,
                    'subtotal' => $harga,
                    'ppn' => $getppn2,
                    'hargappn' => $hargappn2,
                ];

                Mail::to($email)->send(new Invoices($data_ambil));
            }
        }

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function pelanggan_onprogress(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);

        $layanan_id = $request->id_layanan;
        $provinsi_id = $request->id_provinsi;
        $kabupaten_id = $request->id_kabupaten;
        $kecamatan_id = $request->id_kecamatan;
        $desa_id = $request->id_desa;

        $name = $request->name;
        $username = $request->username;
        $password = Hash::make($username);
        $rn = rand(100000, 999999);

        $rml = "@onprogress.com";
        $eml = array($name,$rn,$rml);
        $email = implode($eml);

        $getpelanggan_id = User::query()
            ->where('name','=',$name)
            ->where('username','=',$username)
            ->get();
        $getemail = User::query()
            ->where('email','=',$email)
            ->get();
        $getusername = User::query()
            ->where('username','=',$username)
            ->get();

        if (count($getpelanggan_id)>0){
            return response()->json(['cek'=>0, 'msg'=>'Bukan pelanggan baru!']);
        }elseif(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }elseif(count($getusername)>0){
            return response()->json(['cek'=>2, 'msg'=>'No Hp sudah terpakai!']);
        }elseif($layanan_id==0){
            return response()->json(['cek'=>3, 'msg'=>'Layanan belum dipilih!']);
        }elseif($provinsi_id==0){
            return response()->json(['cek'=>4, 'msg'=>'Data Provinsi belum dipilih!']);
        }elseif($kabupaten_id==0){
            return response()->json(['cek'=>5, 'msg'=>'Data Kabupaten belum dipilih!']);
        }elseif($kecamatan_id==0){
            return response()->json(['cek'=>6, 'msg'=>'Data Kecamatan belum dipilih!']);
        }elseif($desa_id==0){
            return response()->json(['cek'=>7, 'msg'=>'Data Desa belum dipilih!']);
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->user_role = 3;
            $user->status_id = 1;
            $user->ppn = '0';
            $user->save();

            $getpelanggan = User::query()
                ->where('name','=',$name)
                ->where('email','=',$email)
                ->where('username','=',$username)
                ->get()
                ->toArray();
            $objectToArray = (array)$getpelanggan;
            $pela1 = $objectToArray[0];
            $pela2 = (array)$pela1;
            $pelanggan_id2 = $pela2['id_user'];
            $pelanggan_id = $pelanggan_id2;
        }

        $detail_alamat = $request->id_alamat;

        $langganan = new Langganan();
        $langganan->pelanggan_id = $pelanggan_id;
        $langganan->layanan_id = $layanan_id;
        $langganan->provinsi_id = $provinsi_id;
        $langganan->kabupaten_id = $kabupaten_id;
        $langganan->kecamatan_id = $kecamatan_id;
        $langganan->desa_id = $desa_id;
        $langganan->detail_alamat = $detail_alamat;

        $getprovinsi = Province::query()->find($provinsi_id);
        $provinsi = $getprovinsi->name;

        $getkabupaten = Regency::query()->find($kabupaten_id);
        $kabupaten = $getkabupaten->name;

        $getkecamatan = District::query()->find($kecamatan_id);
        $kecamatan = $getkecamatan->name;

        $getdesa = Village::query()->find($desa_id);
        $desa = $getdesa->name;

        $alamat = $detail_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);
        $langganan->status_id = 1;
        $langganan->save();

        return redirect()->back()
            ->with('success','Langganan berhasil ditambahkan.');
    }

    public function setujui_pesan($id_langganan){
        $get_lang = Langganan::query()->find($id_langganan);
        $pelanggan_id = $get_lang->pelanggan_id;
        $user = User::query()->find($pelanggan_id);
        $bts = Bts::all();
        return view('dashboard.admin.pemesanan.approve', compact('get_lang', 'bts', 'user'));
    }

    public function post_setujui_pesan(Request $request, $id_langganan){
        $email2 = $request->email;
        $flag_ppn = $request->ppn;
        $lokasi = $request->lokasi;
        $ll = explode(",",$lokasi);
        $long = $ll[1];
        $lat = $ll[0];
        $bts_id = $request->id_bts;
        $getturunan = $request->id_turunan;
        if ($getturunan==0){
            $turunan_id = null;
        }else{
            $turunan_id = $getturunan;
        }
        $ip = $request->ip;
        $ip_radio = $request->ip_radio;

        $getemail = User::query()
            ->where('email','=',$email2)
            ->get();

        if(count($getemail)>0){
            return response()->json(['cek'=>1, 'msg'=>'Email sudah terpakai!']);
        }elseif($bts_id==0){
            return response()->json(['cek'=>2, 'msg'=>'BTS belum dipilih!']);
        }else{
            $getlang = Langganan::query()->find($id_langganan);
            $getlang->bts_id = $bts_id;
            $getlang->turunan_id = $turunan_id;
            $getlang->ip = $ip;
            $getlang->ip_radio = $ip_radio;
            $getlang->status_id = 2;
            $getlang->longitude = $long;
            $getlang->latitude = $lat;
            $getlang->save();

            $layanan_id = $getlang->layanan_id;
            $pelanggan_id = $getlang->pelanggan_id;

            $getpel = User::query()->find($pelanggan_id);
            $name = $getpel->name;
            $username = $getpel->username;
            $email = $email2;
            $nama_role = 'Pelanggan';

            $tahun = Carbon::now()->format('Y');
            $getppn = Ppn::query()
                ->where('tahun','=',$tahun)
                ->get()
                ->toArray();
            $objectToArray = (array)$getppn;
            $ppn1 = $objectToArray[0];
            $ppn2 = (array)$ppn1;
            $jppn = $ppn2['jumlah'];
            if (count($getppn)!=0){
                if ($flag_ppn == 1){
                    $hppn = '1';
                }else{
                    $hppn = '0';
                }
            }else{
                $hppn = '0';
            }

            $getpel->status_id = 2;
            $getpel->email = $email;
            $getpel->ppn = $hppn;
            $getpel->save();
        }

        $data_ambil = [
            'nama' => $name,
            'nama_role' => $nama_role,
            'username' => $username,
            'email' => $email,
            'password' => $username,
        ];

        Mail::to($email)->send(new MailAdmins($data_ambil));

        $getlayanan = Layanan::query()->find($layanan_id);
        $harga = $getlayanan->harga;

        $huruf = 'INV';
        $acak1 = rand(10, 99);
        $acak2 = rand(10, 99);
        $bulan=Carbon::now()->format('n');
        $lengkap = array($huruf,$acak1,$pelanggan_id,$acak2,$bulan,$tahun);
        $id_invoice = implode($lengkap);

        $tgl_terbit = Carbon::now()->setTimezone('Asia/Jakarta');

        if ($hppn=='1'){
            $getppn2 = $jppn;
        }else{
            $getppn2 = 0;
        }
        $hargappn = $harga*$getppn2/100;
        $harga2 = $harga+$hargappn;

        $invoice = new Invoice();
        $invoice->id_invoice = $id_invoice;
        $invoice->pelanggan_id = $pelanggan_id;
        $invoice->harga_bayar = $harga2;
        $invoice->tagihan = $harga2;
        $invoice->tgl_terbit = $tgl_terbit;
        $invoice->bulan = $bulan;
        $invoice->tahun = $tahun;
        $invoice->ppn = $getppn2;
        $invoice->status_id = 6;
        $invoice->save();

        $langinv = new Langinv();
        $langinv->invoice_id = $id_invoice;
        $langinv->pelanggan_id = $pelanggan_id;
        $langinv->layanan_id = $layanan_id;
        $langinv->harga_satuan = $harga;
        $langinv->langganan_id = $id_langganan;
        $langinv->status_id = 6;
        $langinv->save();

        $langganans = Langinv::query()
            ->where('pelanggan_id', '=', $pelanggan_id)
            ->where('invoice_id', '=', $id_invoice)
            ->where('status_id', '=', 6)
            ->get();

        $data_ambil = [
            'email_cv' => 'info@gudangtechno.web.id',
            'nama_pelanggan' => $name,
            'email_pelanggan' => $email,
            'no_hp_pelanggan' => $username,
            'id_invoice' => $id_invoice,
            'tgl_terbit' => $tgl_terbit,
            'harga_bayar' => $harga2,
            'langganans' => $langganans,
            'subtotal' => $harga,
            'ppn' => $getppn2,
            'hargappn' => $hargappn,
        ];

        Mail::to($email)->send(new Invoices($data_ambil));
    }

    public function tolak_langganan($id_langganan){
        $langganan = Langganan::find($id_langganan);

        $langganan->status_id = 5;
        $langganan->save();

        return redirect()->route('admin.pelangganaktif')->with('success','Langganan '
            .$langganan->layanan->nama_layanan.', pelanggan '.$langganan->pelanggan->name.' berhasil ditolak.');
    }

    public function nonaktif_langganan($id_langganan){
        $langganan = Langganan::find($id_langganan);

        $langganan->status_id = 4;
        $langganan->save();

        DB::table('turunan_bts')
            ->where('langganan_id', '=', $id_langganan)
            ->update([
                'status_id'=>4,
            ]);

        return redirect()->route('admin.pelangganaktif')
            ->with('success','Langganan '
                .$langganan->layanan->nama_layanan.', pelanggan '.$langganan->pelanggan->name.' berhasil dinonaktifkan.');
    }

    public function edit_langganan($id_langganan){
        $get_lang = Langganan::query()->find($id_langganan);
        $pelanggan_id = $get_lang->pelanggan_id;
        $layanan = Layanan::all();
        $provinsi =Province::all();
        $user = User::query()->find($pelanggan_id);
        $bts = Bts::all();
        return view('dashboard.admin.pemesanan.edit', compact('get_lang', 'bts', 'user', 'layanan', 'provinsi'));
    }

    public function postedit_langganan(Request $request, $idlang){
        $layanan = $request->id_layanan;
        $bts = $request->id_bts;
        $ip = $request->ip;
        $ip_radio = $request->ip_radio;
        $id_provinsi = $request->id_provinsi;
        $id_kabupaten = $request->id_kabupaten;
        $id_kecamatan = $request->id_kecamatan;
        $id_desa = $request->id_desa;
        $id_alamat = $request->id_alamat;
        $lokasi = $request->lokasi;
        $ll = explode(",",$lokasi);
        $long = $ll[1];
        $lat = $ll[0];
        $getturunan = $request->id_turunan;
        if ($getturunan==0){
            $turunan_id = null;
        }else{
            $turunan_id = $getturunan;
        }

        $langganan = Langganan::query()->find($idlang);
        $langganan->layanan_id = $layanan;
        $langganan->bts_id = $bts;
        $langganan->turunan_id = $turunan_id;
        $langganan->ip = $ip;
        $langganan->ip_radio = $ip_radio;
        $langganan->provinsi_id = $id_provinsi;
        $langganan->kabupaten_id = $id_kabupaten;
        $langganan->kecamatan_id = $id_kecamatan;
        $langganan->desa_id = $id_desa;
        $langganan->detail_alamat = $id_alamat;

        $getprovinsi = Province::query()->find($id_provinsi);
        $provinsi = $getprovinsi->name;

        $getkabupaten = Regency::query()->find($id_kabupaten);
        $kabupaten = $getkabupaten->name;

        $getkecamatan = District::query()->find($id_kecamatan);
        $kecamatan = $getkecamatan->name;

        $getdesa = Village::query()->find($id_desa);
        $desa = $getdesa->name;

        $alamat = $id_alamat;
        $lengkap = array($alamat,$desa,$kecamatan,$kabupaten,$provinsi);
        $langganan->alamat_pasang = implode(", ",$lengkap);

        $langganan->longitude = $long;
        $langganan->latitude = $lat;
        $langganan->save();

    }

//    get from ajax
    public function get_turunan(Request $request)
    {
        $id_bts = $request->id_bts;

        $turunans = TurunanBts::query()
            ->where('status_id', '=', 2)
            ->orWhere('status_id', '=', 3)
            ->where('bts_id', '=', $id_bts)
            ->get();

        $option = "<option value='0'>Pilih Pelanggan</option>";
        foreach ($turunans as $turunan) {
            $option .= "<option value='$turunan->id_turunan'>$turunan->nama_turunan</option>";
        }
        echo $option;
    }

    public function getKabupaten(Request $request)
    {
        $id_provinsi = $request->id_provinsi;

        $kabupatens = Regency::query()
            ->where('province_id', $id_provinsi)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option value='0'>Pilih Kabupaten</option>";
        foreach ($kabupatens as $kabupaten){
            $option .= "<option value='$kabupaten->id'>$kabupaten->name</option>";
        }
        echo $option;
    }

    public function getKecamatan(Request $request)
    {
        $id_kabupaten = $request->id_kabupaten;

        $kecamatans = District::query()
            ->where('regency_id', $id_kabupaten)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option value='0'>Pilih Kecamatan</option>";
        foreach ($kecamatans as $kecamatan){
            $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
        echo $option;
    }

    public function getDesa(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;

        $desas = Village::query()
            ->where('district_id', $id_kecamatan)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option value='0'>Pilih Desa</option>";
        foreach ($desas as $desa){
            $option .= "<option value='$desa->id'>$desa->name</option>";
        }
        echo $option;
    }

    public function get_turunanedit(Request $request, $idlang)
    {
        $id_bts = $request->id_bts;
        $lang = Langganan::query()->find($idlang);
        $selected = $lang->turunan_id;

        $turunans = TurunanBts::query()
            ->where('bts_id', '=', $id_bts)
            ->where('status_id', '=', 2)
            ->orWhere('status_id', '=', 3)
            ->get();

        if ($selected == null){
            $option = "<option value='0'>Tidak tersambung ke pelanggan lain</option>";
        }else{
            $option = "<option value='0'>Pilih Pelanggan</option>";
        }
        foreach ($turunans as $turunan) {
            if ($turunan->id_turunan == $selected){
                $option .= "<option value='$turunan->id_turunan' selected>$turunan->nama_turunan</option>";
            }else{
                $option .= "<option value='$turunan->id_turunan'>$turunan->nama_turunan</option>";
            }
        }
        echo $option;
    }

    public function getKabupatenedit(Request $request, $idlang)
    {
        $id_provinsi = $request->id_provinsi;
        $lang = Langganan::query()->find($idlang);
        $selected = $lang->kabupaten_id;

        $kabupatens = Regency::query()
            ->where('province_id', $id_provinsi)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Kabupaten</option>";
        foreach ($kabupatens as $kabupaten){
            if ($kabupaten->id == $selected){
                $option .= "<option value='$kabupaten->id' selected>$kabupaten->name</option>";
            }else{
                $option .= "<option value='$kabupaten->id'>$kabupaten->name</option>";
            }
        }
        echo $option;
    }

    public function getKecamatanedit(Request $request, $idlang)
    {
        $id_kabupaten = $request->id_kabupaten;
        $lang = Langganan::query()->find($idlang);
        $selected = $lang->kecamatan_id;

        $kecamatans = District::query()
            ->where('regency_id', $id_kabupaten)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Kecamatan</option>";
        foreach ($kecamatans as $kecamatan){
            if ($kecamatan->id == $selected){
                $option .= "<option value='$kecamatan->id' selected>$kecamatan->name</option>";
            }else{
                $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
            }
        }
        echo $option;
    }

    public function getDesaedit(Request $request, $idlang)
    {
        $id_kecamatan = $request->id_kecamatan;
        $lang = Langganan::query()->find($idlang);
        $selected = $lang->desa_id;

        $desas = Village::query()
            ->where('district_id', $id_kecamatan)
            ->orderBy('name', 'ASC')
            ->get();

        $option = "<option>Pilih Desa</option>";
        foreach ($desas as $desa){
            if ($desa->id == $selected){
                $option .= "<option value='$desa->id' selected>$desa->name</option>";
            }else{
                $option .= "<option value='$desa->id'>$desa->name</option>";
            }
        }
        echo $option;
    }
}
