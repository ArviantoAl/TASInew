<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;
    protected $table = 'langganans';
    protected $primaryKey = 'id_langganan';
    public $incrementing = true;
    protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'alamat_pasang',
        'status',
        'harga_satuan',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'detail_alamat',
        'alamat_pasang',
    ];
    public function layanan(){
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
    public function pelanggan(){
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
    public function provinsi(){
        return $this->belongsTo(Province::class, 'provinsi_id');
    }
    public function kabupaten(){
        return $this->belongsTo(Regency::class, 'kabupaten_id');
    }
    public function kecamatan(){
        return $this->belongsTo(District::class, 'kecamatan_id');
    }
    public function desa(){
        return $this->belongsTo(Village::class, 'desa_id');
    }
}
