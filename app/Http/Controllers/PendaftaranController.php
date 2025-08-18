<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\KajianAwal;


class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query builder untuk Pendaftaran, termasuk relasi pasien & dokter
        $query = Pendaftaran::with(['pasien', 'dokter']);

        // Jika parameter ?tanggal=... di request, tambahkan filter
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_registrasi', $request->tanggal);
        }

        // Ambil data dengan pagination
        $pendaftarans = $query->orderBy('tanggal_registrasi', 'desc')->paginate(10);

        // Kirim data ke view
        return view('admin.pendaftaran', compact('pendaftarans'));
    }
    // API untuk mendapatkan dokter berdasarkan spesialis
    public function getDokterBySpesialis($spesialis)
    {
        $dokters = Dokter::where('spesialis', $spesialis)->get();
        return response()->json($dokters);
    }

    // Cek pasien lama berdasarkan NIK dan tanggal lahir
    public function cekPasienLama(Request $request)
    {
        $pasien = Pasien::where('nik', $request->nik)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if ($pasien) {
            return response()->json([
                'status' => 'found',
                'data' => $pasien
            ]);
        } else {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Pasien tidak ditemukan'
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi dasar
            $request->validate([
                'jenis_pasien' => 'required|in:lama,baru',
                'tanggal_registrasi' => 'required|date',
            ]);

            $pasien = null;

            if ($request->jenis_pasien == 'lama') {
                // Validasi untuk pasien lama
                $request->validate([
                    'nik_lama' => 'required',
                    'tanggal_lahir_lama' => 'required|date',
                    'poli_lama' => 'required',
                    'dokter_lama' => 'required|exists:dokters,id',
                ]);

                // Cari pasien lama
                $pasien = Pasien::where('nik', $request->nik_lama)
                    ->where('tanggal_lahir', $request->tanggal_lahir_lama)
                    ->first();

                if (!$pasien) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data pasien tidak ditemukan. Silakan daftarkan sebagai pasien baru.'
                    ], 422);
                }

                $dokterId = $request->dokter_lama;
                $tanggalRegistrasi = $request->tanggal_registrasi_lama ?? $request->tanggal_registrasi;

            } else {
                // Validasi untuk pasien baru
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|string|size:16|unique:pasiens,nik',
                    'tempat_lahir' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date',
                    'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                    'nama_ayah' => 'required|string|max:255',
                    'nama_ibu' => 'required|string|max:255',
                    'agama' => 'required|string|max:100',
                    'alamat' => 'required|string',
                    'pendidikan' => 'required|string|max:100',
                    'pekerjaan' => 'required|string|max:100',
                    'status' => 'required|string|max:100',
                    'penanggung_hubungan' => 'required|string|max:100',
                    'penanggung_nama' => 'required|string|max:255',
                    'penanggung_alamat' => 'required|string',
                    'penanggung_pekerjaan' => 'required|string|max:100',
                    'penanggung_gender' => 'required|in:Laki-laki,Perempuan',
                    'penanggung_agama' => 'required|string|max:100',
                    'penanggung_status' => 'required|string|max:100',
                    'no_whatsapp' => 'required|string|max:20',
                    'poli_baru' => 'required',
                    'dokter_baru' => 'required|exists:dokters,id',
                ]);

                // Buat pasien baru
                $pasien = Pasien::create([
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nama_ayah' => $request->nama_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'pendidikan' => $request->pendidikan,
                    'pekerjaan' => $request->pekerjaan,
                    'status' => $request->status,
                    'penanggung_hubungan' => $request->penanggung_hubungan,
                    'penanggung_nama' => $request->penanggung_nama,
                    'penanggung_alamat' => $request->penanggung_alamat,
                    'penanggung_pekerjaan' => $request->penanggung_pekerjaan,
                    'penanggung_gender' => $request->penanggung_gender,
                    'penanggung_agama' => $request->penanggung_agama,
                    'penanggung_status' => $request->penanggung_status,
                    'no_whatsapp' => $request->no_whatsapp,
                ]);

                $dokterId = $request->dokter_baru;
                $tanggalRegistrasi = $request->tanggal_registrasi_baru ?? $request->tanggal_registrasi;
            }

            // Cek apakah pasien sudah terdaftar pada dokter dan tanggal yang sama
            if (Pendaftaran::isAlreadyRegistered($pasien->id, $dokterId, $tanggalRegistrasi)) {
                DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pasien sudah terdaftar pada dokter dan tanggal yang sama.'
                ], 422);
            }

            // Generate nomor antrian dengan locking untuk mencegah race condition
            $nomorAntrian = $this->generateNomorAntrianWithLock($dokterId, $tanggalRegistrasi);

            // Log untuk debugging
            Log::info('Generating nomor antrian', [
                'dokter_id' => $dokterId,
                'tanggal' => $tanggalRegistrasi,
                'nomor_antrian' => $nomorAntrian
            ]);

            // Buat pendaftaran
            $pendaftaran = Pendaftaran::create([
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokterId,
                'tanggal_registrasi' => $tanggalRegistrasi,
                'nomor_antrian' => $nomorAntrian,
                'status' => 'Belum Kajian Awal',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil disimpan',
                'data' => [
                    'pendaftaran' => $pendaftaran,
                    'nomor_antrian' => $nomorAntrian,
                    'pasien' => $pasien->nama,
                    'dokter' => Dokter::find($dokterId)->nama,
                    'tanggal_registrasi' => $tanggalRegistrasi
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in store pendaftaran: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate nomor antrian dengan database locking untuk mencegah race condition
     */
    private function generateNomorAntrianWithLock($dokterId, $tanggal)
    {
        return DB::transaction(function () use ($dokterId, $tanggal) {
            // Ambil data spesialis dokter
            $dokter = Dokter::findOrFail($dokterId);
            $prefix = strtoupper(substr($dokter->spesialis, 0, 1)); // U untuk Umum, G untuk Gigi, dst

            // Lock untuk hitung antrian hari itu berdasarkan dokter
            $count = DB::table('pendaftarans')
                ->where('dokter_id', $dokterId)
                ->whereDate('tanggal_registrasi', $tanggal)
                ->lockForUpdate()
                ->count();

            return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT); // U001, G002, dst
        });
    }

    /**
     * Generate nomor antrian berdasarkan dokter dan tanggal (backup method)
     */
    private function generateNomorAntrian($dokterId, $tanggal)
    {
        $dokter = Dokter::findOrFail($dokterId);
        $prefix = strtoupper(substr($dokter->spesialis, 0, 1));

        $count = Pendaftaran::where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $tanggal)
            ->count();

        return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }


    /**
     * Update pendaftaran
     */
    public function update(Request $request, $id)
    {
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);

            if ($request->has('status')) {
                $request->validate([
                    'status' => 'required|in:Belum Kajian Awal,Selesai'
                ]);

                $pendaftaran->update([
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Status pendaftaran berhasil diupdate'
                ]);
            }

            $request->validate([
                'dokter_id' => 'sometimes|exists:dokters,id',
                'tanggal_registrasi' => 'sometimes|date',
                'status' => 'sometimes|in:Belum Kajian Awal,Selesai'
            ]);

            $pendaftaran->update($request->only(['dokter_id', 'tanggal_registrasi', 'status']));

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil diupdate',
                'data' => $pendaftaran->load(['pasien', 'dokter'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy($id)
    {
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);
            $pendaftaran->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show detail pendaftaran
     */
    public function show($id)
    {
        try {
            $pendaftaran = Pendaftaran::with(['pasien', 'dokter'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $pendaftaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pendaftaran tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Get statistik pendaftaran
     */
    public function getStatistik()
    {
        $today = now()->toDateString();

        $statistik = [
            'total_hari_ini' => Pendaftaran::whereDate('tanggal_registrasi', $today)->count(),
            'belum_kajian_awal' => Pendaftaran::whereDate('tanggal_registrasi', $today)->where('status', 'Belum Kajian Awal')->count(),
            'selesai' => Pendaftaran::whereDate('tanggal_registrasi', $today)->where('status', 'Selesai')->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $statistik
        ]);
    }

    /**
     * Export data pendaftaran (CSV)
     */
    public function export(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'dokter']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_registrasi', [$request->start_date, $request->end_date]);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query->get();

        $filename = 'pendaftaran_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($pendaftarans) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'No Antrian',
                'Nama Pasien',
                'NIK',
                'Dokter',
                'Spesialis',
                'Tanggal Booking',
                'Status',
                'Created At'
            ]);

            foreach ($pendaftarans as $pendaftaran) {
                fputcsv($file, [
                    $pendaftaran->nomor_antrian,
                    $pendaftaran->pasien->nama,
                    $pendaftaran->pasien->nik,
                    $pendaftaran->dokter->nama,
                    $pendaftaran->dokter->spesialis,
                    $pendaftaran->tanggal_registrasi,
                    ucfirst($pendaftaran->status),
                    $pendaftaran->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get nomor antrian selanjutnya untuk preview
     */
    public function getNextNomorAntrian(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_registrasi' => 'required|date'
        ]);

        $nextNumber = $this->generateNomorAntrian($request->dokter_id, $request->tanggal_registrasi);

        return response()->json([
            'status' => 'success',
            'nomor_antrian' => $nextNumber
        ]);
    }

    public function simpanKajianAwal(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'suhu_tubuh' => 'required|numeric',
            'tekanan_darah' => 'required|string',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'keluhan' => 'required|string',
        ]);

        // Ambil data pendaftaran
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Simpan kajian awal dengan dokter_id dari pendaftaran
        KajianAwal::create([
            'pendaftaran_id' => $request->pendaftaran_id,
            'dokter_id' => $pendaftaran->dokter_id,
            'suhu_tubuh' => $request->suhu_tubuh,
            'tekanan_darah' => $request->tekanan_darah,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'keluhan' => $request->keluhan,
        ]);

        // Update status pendaftaran
        $pendaftaran->status = 'Selesai';
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Kajian Awal berhasil disimpan.');
    }

    public function rekamMedis()
    {
        $rekamMedis = KajianAwal::with(['pendaftaran.pasien', 'pendaftaran.dokter'])
            ->latest()
            ->get();

        return view('admin.rekammedis', compact('rekamMedis'));
    }

    public function dataPasien()
    {
        $kajianAwals = KajianAwal::with(['pendaftaran.pasien'])->latest()->get();

        return view('admin.datapasien', compact('kajianAwals'));
    }

    public function dataAntrian(Request $request)
    {
        // Ambil tanggal dari filter, default hari ini
        $tanggal = $request->input('tanggal', now()->toDateString());

        $antrianUmum = Pendaftaran::with(['pasien', 'dokter'])
            ->whereHas('dokter', fn($q) => $q->where('spesialis', 'Umum'))
            ->whereDate('tanggal_registrasi', $tanggal)
            ->orderBy('tanggal_registrasi')
            ->paginate(5, ['*'], 'umum_page');

        $antrianGigi = Pendaftaran::with(['pasien', 'dokter'])
            ->whereHas('dokter', fn($q) => $q->where('spesialis', 'Gigi'))
            ->whereDate('tanggal_registrasi', $tanggal)
            ->orderBy('tanggal_registrasi')
            ->paginate(5, ['*'], 'gigi_page');

        return view('admin.dataantrian', compact('antrianUmum', 'antrianGigi', 'tanggal'));
    }

    public function panggilPasien($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = 'Dalam Perawatan';
        $pendaftaran->save();

        return redirect()->route('admin.dataantrian')->with('success', 'Pasien telah dipanggil.');
    }

    public function getAntrianTerkini()
    {
        $today = now()->toDateString();

        $umum = Pendaftaran::whereHas('dokter', fn($q) => $q->where('spesialis', 'Umum'))
            ->where('status', 'Dalam Perawatan')
            ->whereDate('tanggal_registrasi', $today)
            ->orderByDesc('updated_at')
            ->first();

        $gigi = Pendaftaran::whereHas('dokter', fn($q) => $q->where('spesialis', 'Gigi'))
            ->where('status', 'Dalam Perawatan')
            ->whereDate('tanggal_registrasi', $today)
            ->orderByDesc('updated_at')
            ->first();

        return response()->json([
            'umum' => $umum?->nomor_antrian ?? null,
            'gigi' => $gigi?->nomor_antrian ?? null,
        ]);
    }

}