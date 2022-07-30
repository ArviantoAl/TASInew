<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilCv extends Model
{
    use HasFactory;
    protected $table = 'profilcv';
    protected $primaryKey = 'id_profil';
    public $incrementing = true;
    protected $fillable = [
        'nama_cv',
        'email_cv',
        'logo_cv',
        'export_invoice',
    ];
}
