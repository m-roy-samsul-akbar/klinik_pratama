<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KajianAwal;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    // =========================================================
    // =================== HALAMAN ADMIN =======================
    // =========================================================

    public function index(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'dokter'])
            ->when($request->filled('tanggal'), fn($q) =>
                $q->whereDate('tanggal_registrasi', $request->tanggal))
            ->orderByDesc('tanggal_registrasi');

        $pendaftarans = $query->paginate(10)->withQueryString();

        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function tidakHadir(Request $request)
    {
        $pendaftaran = Pendaftaran::find($request->id);
        if (!$pendaftaran) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $pendaftaran->status = 'Tidak Hadir';
        $pendaftaran->save();

        return response()->json(['success' => true]);
    }

    // ====== API ADMIN ======

    // Dokter by spesialis (Umum/Gigi)
    public function getDokterBySpesialis(string $spesialis)
    {
        $dokters = Dokter::where('spesialis', $spesialis)->get(['id', 'nama', 'spesialis']);
        return response()->json(['data' => $dokters]);
    }

    // Jam praktek dokter
    public function getJamPraktek(Request $request)
    {
        $request->validate(['dokter_id' => 'required|exists:dokters,id']);
        $dokter = Dokter::find($request->dokter_id);

        return response()->json([
            'data' => ['jam_praktek' => $dokter->jam_praktek]
        ]);
    }

    // =========================================================
    // ==================== FORM PUBLIK ========================
    // =========================================================

    /**
     * Endpoint CEK PASIEN (boleh dipanggil dari publik).
     * Harap buat route: POST /api/pasien/cek -> cekPasienLama
     */
    public function cekPasienLama(Request $request)
    {
        // Validasi sederhana (hindari 500 + HTML error page)
        $data = $request->validate([
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
        ]);

        $pasien = Pasien::where('nik', $data['nik'])
            ->where('tanggal_lahir', $data['tanggal_lahir'])
            ->first();

        if (!$pasien) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Pasien tidak ditemukan'
            ], 200);
        }

        return response()->json([
            'status' => 'found',
            'data' => $pasien
        ], 200);
    }

    // =========================================================
    // ================== CRUD PENDAFTARAN =====================
    // =========================================================

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'jenis_pasien' => 'required|in:lama,baru',
            ]);

            $pasien = null;
            $dokterId = null;
            $tanggalRegistrasi = null;

            if ($request->jenis_pasien === 'lama') {
                // validasi & ambil pasien lama
                $request->validate([
                    'nik_lama' => 'required|digits:16',
                    'tanggal_lahir_lama' => 'required|date',
                    'poli_lama' => 'required|string',
                    'dokter_lama' => 'required|exists:dokters,id',
                    'tanggal_registrasi_lama' => 'required|date',
                ]);

                $pasien = Pasien::where('nik', $request->nik_lama)
                    ->where('tanggal_lahir', $request->tanggal_lahir_lama)
                    ->first();

                if (!$pasien) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data pasien tidak ditemukan. Silakan daftarkan sebagai pasien baru.'
                    ], 422);
                }

                $dokterId = (int) $request->dokter_lama;
                $tanggalRegistrasi = $request->tanggal_registrasi_lama;
            } else {
                // buat pasien baru
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|digits:16|unique:pasiens,nik',
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
                    'poli_baru' => 'required|string',
                    'dokter_baru' => 'required|exists:dokters,id',
                    'tanggal_registrasi_baru' => 'required|date',
                ]);

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
                    'no_whatsapp' => $this->normalizePhone($request->no_whatsapp),
                ]);

                $dokterId = (int) $request->dokter_baru;
                $tanggalRegistrasi = $request->tanggal_registrasi_baru;
            }

            // Cegah duplikasi (pasien, dokter, tanggal)
            if (
                method_exists(Pendaftaran::class, 'isAlreadyRegistered')
                && Pendaftaran::isAlreadyRegistered($pasien->id, $dokterId, $tanggalRegistrasi)
            ) {

                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pasien sudah terdaftar pada dokter dan tanggal yang sama.'
                ], 422);
            }

            // Nomor antrian aman
            $noAntrian = $this->generateNomorAntrianWithLock($dokterId, $tanggalRegistrasi);

            // Simpan pendaftaran
            $pendaftaran = Pendaftaran::create([
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokterId,
                'tanggal_registrasi' => $tanggalRegistrasi,
                'nomor_antrian' => $noAntrian,
                'status' => 'Belum Kajian Awal',
            ]);

            $dokter = Dokter::find($dokterId);

            DB::commit();

            // Kirim WA (opsional, jika consent)
            $waResult = null;
            $shouldSend = (bool) $request->boolean('consent');
            $targetWa = $this->normalizePhone($request->input('whatsapp') ?: $pasien->no_whatsapp);

            if ($shouldSend && $targetWa) {
                $message = $this->buildAntrianMessage($pasien, $dokter, $pendaftaran);
                $waResult = $this->callFonnteApi([
                    'target' => $targetWa,
                    'message' => $message,
                    'schedule' => null,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil disimpan',
                'data' => [
                    'pendaftaran' => $pendaftaran,
                    'nomor_antrian' => $noAntrian,
                    'pasien' => $pasien->nama,
                    'dokter' => $dokter?->nama,
                    'tanggal_registrasi' => $tanggalRegistrasi,
                    'whatsapp' => [
                        'attempted' => $shouldSend,
                        'target' => $shouldSend ? $targetWa : null,
                        'result' => $waResult,
                    ],
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Store pendaftaran error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);

            $request->validate([
                'dokter_id' => 'sometimes|exists:dokters,id',
                'tanggal_registrasi' => 'sometimes|date',
                'status' => 'sometimes|in:Belum Kajian Awal,Dalam Perawatan,Tidak Hadir,Selesai',
            ]);

            $pendaftaran->update($request->only(['dokter_id', 'tanggal_registrasi', 'status']));

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil diupdate',
                'data' => $pendaftaran->load(['pasien', 'dokter'])
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);
            $pendaftaran->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil dihapus'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pendaftaran = Pendaftaran::with(['pasien', 'dokter'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $pendaftaran
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pendaftaran tidak ditemukan'
            ], 404);
        }
    }

    public function getStatistik()
    {
        $today = now()->toDateString();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_hari_ini' => Pendaftaran::whereDate('tanggal_registrasi', $today)->count(),
                'belum_kajian_awal' => Pendaftaran::whereDate('tanggal_registrasi', $today)->where('status', 'Belum Kajian Awal')->count(),
                'selesai' => Pendaftaran::whereDate('tanggal_registrasi', $today)->where('status', 'Selesai')->count(),
            ]
        ]);
    }

    public function export(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'dokter']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_registrasi', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query->get();

        $filename = 'pendaftaran_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($pendaftarans) {
            $f = fopen('php://output', 'w');
            fputcsv($f, ['No Antrian', 'Nama Pasien', 'NIK', 'Dokter', 'Spesialis', 'Tanggal Booking', 'Status', 'Created At']);
            foreach ($pendaftarans as $p) {
                fputcsv($f, [
                    $p->nomor_antrian,
                    $p->pasien->nama,
                    $p->pasien->nik,
                    $p->dokter->nama,
                    $p->dokter->spesialis,
                    $p->tanggal_registrasi,
                    ucfirst($p->status),
                    $p->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getNextNomorAntrian(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_registrasi' => 'required|date'
        ]);

        $next = $this->generateNomorAntrian($request->dokter_id, $request->tanggal_registrasi);

        return response()->json([
            'status' => 'success',
            'nomor_antrian' => $next
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

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        KajianAwal::create([
            'pendaftaran_id' => $request->pendaftaran_id,
            'dokter_id' => $pendaftaran->dokter_id,
            'suhu_tubuh' => $request->suhu_tubuh,
            'tekanan_darah' => $request->tekanan_darah,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'keluhan' => $request->keluhan,
        ]);

        $pendaftaran->status = 'Selesai';
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Kajian Awal berhasil disimpan.');
    }

    // =========================================================
    // =================== ANTRIAN DISPLAY =====================
    // =========================================================

    public function dataAntrian(Request $request)
    {
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
        $p = Pendaftaran::findOrFail($id);
        $p->status = 'Dalam Perawatan';
        $p->save();

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
            'umum' => $umum?->nomor_antrian,
            'gigi' => $gigi?->nomor_antrian,
        ]);
    }

    // =========================================================
    // ===================== UTILITIES =========================
    // =========================================================

    private function generateNomorAntrianWithLock($dokterId, $tanggal)
    {
        return DB::transaction(function () use ($dokterId, $tanggal) {
            $dokter = Dokter::findOrFail($dokterId);
            $prefix = strtoupper(substr($dokter->spesialis, 0, 1)); // U / G / ...

            $count = DB::table('pendaftarans')
                ->where('dokter_id', $dokterId)
                ->whereDate('tanggal_registrasi', $tanggal)
                ->lockForUpdate()
                ->count();

            return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT); // U001, G002, ...
        });
    }

    private function generateNomorAntrian($dokterId, $tanggal)
    {
        $dokter = Dokter::findOrFail($dokterId);
        $prefix = strtoupper(substr($dokter->spesialis, 0, 1));

        $count = Pendaftaran::where('dokter_id', $dokterId)
            ->whereDate('tanggal_registrasi', $tanggal)
            ->count();

        return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    protected function buildAntrianMessage(Pasien $pasien, ?Dokter $dokter, Pendaftaran $pendaftaran): string
    {
        $tgl = \Carbon\Carbon::parse($pendaftaran->tanggal_registrasi)
            ->locale('id_ID')->isoFormat('dddd, D MMMM YYYY');
        $dokterLine = $dokter ? "{$dokter->nama} ({$dokter->spesialis})" : '-';

        return
            "Assalamualaikum/Salam hangat 🙏

Pendaftaran Anda di Klinik Pratama Aisyiyah **berhasil**. Berikut detailnya:

• Nama Pasien   : {$pasien->nama}
• Nomor Antrian : {$pendaftaran->nomor_antrian}
• Dokter        : {$dokterLine}
• Tanggal       : {$tgl}

Mohon:
1) Hadir **tepat waktu** sesuai jadwal,
2) Membawa **kartu identitas**/RM jika ada,
3) Konfirmasi kehadiran bila ada perubahan rencana.

Terima kasih atas kepercayaannya. Semoga lekas sehat! 🌿";
    }

    protected function callFonnteApi(array $payload): array
    {
        $token = config('services.fonnte.token', env('FONNTE_TOKEN'));
        if (!$token) {
            return ['ok' => false, 'error' => 'FONNTE_TOKEN belum diset'];
        }

        try {
            $res = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', array_filter($payload, fn($v) => !is_null($v)));

            return $this->parseFonnteResponse($res);
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => 'Gagal menghubungi Fonnte: ' . $e->getMessage()];
        }
    }

    protected function parseFonnteResponse(\Illuminate\Http\Client\Response $res): array
    {
        $status = $res->status();
        $json = $res->json();

        if ($res->successful()) {
            return [
                'ok' => (bool) ($json['status'] ?? true),
                'status_code' => $status,
                'data' => $json,
            ];
        }

        return [
            'ok' => false,
            'status_code' => $status,
            'error' => $json['detail'] ?? $json['message'] ?? $res->body(),
        ];
    }

    // Bukti pendaftaran (public page)
    public function buktipendaftaran(Request $request)
    {
        $nikRaw = (string) $request->input('nik');
        $nik = preg_replace('/\D/', '', $nikRaw);
        $tanggal = $request->input('tanggal');

        Validator::make(
            ['nik' => $nik, 'tanggal' => $tanggal],
            ['nik' => 'nullable|digits:16', 'tanggal' => 'nullable|date'],
            ['nik.digits' => 'NIK harus 16 digit.', 'tanggal.date' => 'Tanggal tidak valid.']
        )->validate();

        $pendaftaran = null;

        if (!empty($nik)) {
            $pasienId = Pasien::where('nik', $nik)->value('id');
            if ($pasienId) {
                $q = Pendaftaran::with(['pasien', 'dokter'])->where('pasien_id', $pasienId);
                if (!empty($tanggal)) {
                    $q->whereDate('tanggal_registrasi', $tanggal);
                }
                $pendaftaran = $q->latest('tanggal_registrasi')->latest()->first();
            }
        }

        return view('pages.buktipendaftaran', compact('pendaftaran', 'nik', 'tanggal'));
    }

    // ---- helpers ----
    private function normalizePhone(?string $v): ?string
    {
        if (!$v)
            return null;
        $v = preg_replace('/\D/', '', $v);
        if (str_starts_with($v, '08'))
            $v = '62' . substr($v, 1);
        return $v;
    }
}
