<?php

namespace App\Http\Controllers;

use App\Models\KajianAwal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKajianAwalExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = KajianAwal::with('pendaftaran.pasien')->orderBy('created_at', 'desc');

        // Filter per hari
        if ($request->filter_type === 'hari' && $request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter per bulan
        if ($request->filter_type === 'bulan' && $request->filled('bulan')) {
            $query->whereYear('created_at', substr($request->bulan, 0, 4))
                ->whereMonth('created_at', substr($request->bulan, 5, 2));
        }

        $data = $query->paginate(5)->withQueryString();

        return view('dokter.laporan', compact('data'));
    }

    public function exportPdf(Request $request)
    {
        // Ambil data dari database, sesuaikan dengan struktur kamu
        $data = KajianAwal::with('pendaftaran.pasien', 'dokter')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at->format('d-m-Y'),
                    'nomor_rm' => $item->nomor_rekam_medis,
                    'nama' => $item->pendaftaran->pasien->nama ?? '-',
                    'keluhan' => $item->keluhan ?? '-',
                    'diagnosis' => $item->diagnosis ?? '-',
                    'obat' => $item->obat ?? '-',
                ];
            });

        // Kirim ke PDF view
        $pdf = Pdf::loadView('laporan.pdf', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan_kunjungan_pasien.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanKajianAwalExport, 'laporan_kunjungan_pasien.xlsx');
    }
}
  