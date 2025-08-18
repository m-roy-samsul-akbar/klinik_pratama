<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $table = 'jadwal_dokters';

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $casts = [
        'hari' => 'array',  // Cast JSON ke array
    ];

    // Relasi ke model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // Accessor untuk menampilkan jam praktek
    public function getJamPraktekAttribute()
    {
        $jamMulai = date('H:i', strtotime($this->jam_mulai));
        $jamSelesai = date('H:i', strtotime($this->jam_selesai));
        return $jamMulai . ' - ' . $jamSelesai;
    }

    // Accessor untuk menampilkan hari sebagai string
    public function getHariDisplayAttribute()
    {
        if (is_array($this->hari)) {
            return implode(', ', $this->hari);
        }
        return $this->hari;
    }
}