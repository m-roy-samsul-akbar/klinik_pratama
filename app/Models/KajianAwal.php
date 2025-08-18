<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KajianAwal extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'dokter_id',
        'suhu_tubuh',
        'tekanan_darah',
        'tinggi_badan',
        'berat_badan',
        'keluhan',
        'diagnosis',
        'obat',
        'nomor_rekam_medis'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }


}

