<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ambil bulan & tahun dari request atau default sekarang
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));

        $today = Carbon::today();

        // Query dasar untuk filter bulan & tahun
        $baseQuery = Pendaftaran::whereMonth('tanggal_registrasi', $bulan)
            ->whereYear('tanggal_registrasi', $tahun);

        // Statistik
        $totalHariIni = Pendaftaran::whereDate('tanggal_registrasi', $today)->count();
        $totalBulanIni = (clone $baseQuery)->count();
        $totalUmum = (clone $baseQuery)->whereHas('dokter', fn($q) => $q->where('spesialis', 'Umum'))->count();
        $totalGigi = (clone $baseQuery)->whereHas('dokter', fn($q) => $q->where('spesialis', 'Gigi'))->count();
        $totalPasien = Pendaftaran::count();
        $menunggu = (clone $baseQuery)->where('status', 'Belum Kajian Awal')->count();

        // Data untuk grafik (per tanggal di bulan yang dipilih)
        $chartData = (clone $baseQuery)
            ->selectRaw('DATE(tanggal_registrasi) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(fn($item) => [
                'tanggal' => Carbon::parse($item->tanggal)->translatedFormat('d M'),
                'jumlah' => $item->jumlah
            ]);

        return view('admin.dashboard', compact(
            'totalHariIni',
            'totalBulanIni',
            'totalUmum',
            'totalGigi',
            'totalPasien',
            'menunggu',
            'chartData',
            'bulan',
            'tahun'
        ));
    }
}
