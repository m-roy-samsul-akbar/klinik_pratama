<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'agama',
        'alamat',
        'pendidikan',
        'pekerjaan',
        'status',
        'penanggung_hubungan',
        'penanggung_nama',
        'penanggung_alamat',
        'penanggung_pekerjaan',
        'penanggung_gender',
        'penanggung_agama',
        'penanggung_status',
        'no_whatsapp',
    ];

    protected $dates = ['tanggal_lahir'];

    // Relasi dengan pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}