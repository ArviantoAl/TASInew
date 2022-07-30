<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppn extends Model
{
    use HasFactory;
    protected $table = 'ppn';
    protected $primaryKey = 'id_ppn';
    public $incrementing = true;
    protected $fillable = [
        'tahun',
        'jumlah',
    ];
}
