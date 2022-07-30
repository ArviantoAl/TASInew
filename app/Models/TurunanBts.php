<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurunanBts extends Model
{
    use HasFactory;
    protected $table = 'turunan_bts';
    protected $primaryKey = 'id_turunan';
    public $incrementing = true;
    protected $fillable = [
        'nama_turunan',
        'bts_id',
        'langganan_id',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'detail_alamat',
        'alamat_pasang',
        'status_id',
        'frekuensi',
        'ssid',
        'ip',
        'lokasi',
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function bts(){
        return $this->belongsTo(Bts::class, 'bts_id');
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
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
}
