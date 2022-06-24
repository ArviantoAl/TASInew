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
        'tgl_terbit',
        'tgl_tempo',
        'harga_bayar',
        'status',
        'pelanggan_id',
    ];

    public function pelanggan(){
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
}