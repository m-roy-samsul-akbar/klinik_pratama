<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_antrian',
        'pasien_id',
        'dokter_id',
        'tanggal_registrasi',
        'status',
    ];

    protected $dates = ['tanggal_registrasi'];

    // Relasi dengan pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi dengan dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function kajianAwal()
    {
        return $this->hasOne(KajianAwal::class);
    }

    /**
     * Generate nomor antrian berdasarkan dokter dan tanggal
     * Method yang benar - sesuai dengan yang ada di controller
     */
    public static function generateNomorAntrian($dokterId, $tanggal)
    {
        // Hitung jumlah pendaftaran pada dokter dan tanggal yang sama
        $count = self::where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $tanggal)
            ->count();

        // Format: A001, A002, dst
        return 'A' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Alternative method - generate nomor antrian hanya berdasarkan tanggal
     * (jika ingin nomor antrian global per hari, bukan per dokter)
     */
    public static function generateNomorAntrianGlobal($tanggal)
    {
        $count = self::whereDate('tanggal_registrasi', $tanggal)->count();
        return 'A' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get nomor antrian selanjutnya untuk dokter tertentu pada tanggal tertentu
     */
    public static function getNextNomorAntrian($dokterId, $tanggal)
    {
        return self::generateNomorAntrian($dokterId, $tanggal);
    }

    /**
     * Cek apakah pasien sudah terdaftar pada dokter dan tanggal yang sama
     */
    public static function isAlreadyRegistered($pasienId, $dokterId, $tanggal)
    {
        return self::where('pasien_id', $pasienId)
            ->where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $tanggal)
            ->exists();
    }

    /**
     * Get total pendaftaran per dokter pada tanggal tertentu
     */
    public static function getTotalPendaftaranPerDokter($dokterId, $tanggal)
    {
        return self::where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $tanggal)
            ->count();
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $tanggal)
    {
        return $query->whereDate('tanggal_registrasi', $tanggal);
    }

    /**
     * Scope untuk filter berdasarkan dokter
     */
    public function scopeByDokter($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}