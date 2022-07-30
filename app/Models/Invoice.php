<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $primaryKey = 'id_invoice';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_invoice',
        'pelanggan_id',
        'tgl_terbit',
        'tgl_tempo',
        'harga_bayar',
        'tagihan',
        'status_id',
        'bukti_bayar',
        'bulan',
        'tahun',
    ];

    public function pelanggan(){
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
}
