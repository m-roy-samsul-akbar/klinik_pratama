<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KajianAwal;
use Illuminate\Support\Carbon;

class DashboardDokterController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama dokter.
     */
    public function index()
    {
        // Data awal (jika mau kirim default ke view, bisa juga langsung dari AJAX di sisi client)
        return view('dokter.dashboard');
    }

    /**
     * Endpoint realtime untuk mengambil data dashboard secara dinamis via AJAX.
     */
    public function getRealtimeData()
    {
        $today = Carbon::today();

        // Jumlah pasien hari ini
        $jumlahPasienHariIni = KajianAwal::whereDate('created_at', $today)->count();

        // Total pasien bulan ini
        $totalPasienBulanIni = KajianAwal::whereMonth('created_at', $today->month)->count();

        // Konsultasi hari ini (yang sudah ada diagnosis)
        $jumlahKonsultasiHariIni = KajianAwal::whereDate('created_at', $today)
            ->whereNotNull('diagnosis')
            ->count();

        // Antrian hari ini (yang belum ada diagnosis)
        $jumlahAntrian = KajianAwal::whereDate('created_at', $today)
            ->whereNull('diagnosis')
            ->count();

        // Daftar pasien hari ini
        $daftarPasien = KajianAwal::with('pendaftaran.pasien')
            ->whereDate('created_at', $today)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nomor_rm' => $item->nomor_rekam_medis ?? '-',
                    'nama' => $item->pendaftaran->pasien->nama ?? '-',
                    'jam' => $item->created_at->format('H:i'),
                    'keluhan' => $item->keluhan ?? '-',
                    'status' => $item->diagnosis ? 'Selesai' : ($item->diagnosis === null ? 'Menunggu' : 'Sedang dilayani'),
                ];
            });

        return response()->json([
            'hari_ini' => $jumlahPasienHariIni,
            'total_bulan_ini' => $totalPasienBulanIni,
            'konsultasi' => $jumlahKonsultasiHariIni,
            'antrian' => $jumlahAntrian,
            'pasien' => $daftarPasien,
        ]);
    }
}
