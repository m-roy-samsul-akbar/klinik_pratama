<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'alamat',
        'spesialis',
        'telepon',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi One-to-Many: Dokter punya banyak jadwal
    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kajianAwals()
    {
        return $this->hasMany(KajianAwal::class);
    }


    public function getJamPraktekAttribute()
    {
        $mulai = Carbon::createFromFormat('H:i:s', $this->jam_mulai)->format('H:i');
        $selesai = Carbon::createFromFormat('H:i:s', $this->jam_selesai)->format('H:i');
        return "$mulai - $selesai WIB";
    }
}
