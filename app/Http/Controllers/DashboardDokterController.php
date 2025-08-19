<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Pendaftaran;

class DashboardDokterController extends Controller
{
    public function index()
    {
        // Blade sudah hitung angka di sisi view; cukup render
        return view('dokter.dashboard');
    }

    /**
     * Data realtime untuk tabel & ringkasan — dibatasi per dokter (user login).
     */
    public function getRealtimeData(Request $request)
    {
        $dokterId = Dokter::where('user_id', auth()->id())->value('id');
        if (!$dokterId) {
            return response()->json([
                'status' => 'ok',
                'rows'   => [],
                'counts' => ['antrian' => 0, 'pasien_hari_ini' => 0, 'tidak_hadir' => 0],
            ]);
        }

        $today = now()->toDateString();

        $pendaftarans = Pendaftaran::with(['pasien', 'kajianAwal'])
            ->where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $today)
            ->orderBy('created_at')
            ->get();

        $rows = $pendaftarans->map(function ($p) {
            return [
                'no_rm'   => $p->pasien->id ?? '-',             // sesuaikan jika ada kolom no_rm
                'nama'    => $p->pasien->nama ?? '-',
                'jam'     => optional($p->created_at)->format('H:i'),
                'keluhan' => optional($p->kajianAwal)->keluhan ?? '-',
                'status'  => $p->status,
            ];
        });

        $counts = [
            'antrian'         => Pendaftaran::where('dokter_id', $dokterId)
                                    ->whereDate('tanggal_registrasi', $today)
                                    ->where('status', 'Dalam Perawatan')->count(),
            'pasien_hari_ini' => Pendaftaran::where('dokter_id', $dokterId)
                                    ->whereDate('tanggal_registrasi', $today)->count(),
            'tidak_hadir'     => Pendaftaran::where('dokter_id', $dokterId)
                                    ->whereDate('tanggal_registrasi', $today)
                                    ->where('status', 'Tidak Hadir')->count(),
        ];

        return response()->json([
            'status' => 'ok',
            'today'  => $today,
            'rows'   => $rows,
            'counts' => $counts,
        ]);
    }
}
