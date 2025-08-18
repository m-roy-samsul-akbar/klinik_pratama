<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KajianAwal;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KajianController extends Controller
{
    /**
     * Tampilkan daftar kajian awal untuk dokter yang sedang login.
     */
    public function kajianAwalPasien()
    {
        $user = Auth::user();

        // Validasi role dokter
        if (!$user->isDokter()) {
            abort(403, 'Akses hanya untuk dokter.');
        }

        // Cari dokter berdasarkan user login
        $dokter = $user->dokter;

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan.');
        }

        // Ambil kajian awal pasien berdasarkan dokter_id dan yang belum ada diagnosis
        $kajianAwals = KajianAwal::with(['pendaftaran.pasien'])
            ->whereHas('pendaftaran', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id)
                    ->whereNull('diagnosis');
            })
            ->latest()
            ->paginate(10); // GANTI dari ->get() ke ->paginate(10)

        return view('dokter.kajianawal', compact('kajianAwals'));
    }

    /**
     * Simpan diagnosis dari dokter.
     */
    public function simpanDiagnosis(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kajian_awals,id',
            'diagnosis' => 'required|string',
            'obat' => 'nullable|string',
        ]);

        $kajian = KajianAwal::findOrFail($request->id);
        $kajian->diagnosis = $request->diagnosis;
        $kajian->obat = $request->obat;

        $tanggal = now()->format('Ymd');
        $dokterId = $kajian->pendaftaran->dokter_id;

        // Hitung jumlah RM untuk dokter ini di hari ini
        $countToday = KajianAwal::whereHas('pendaftaran', function ($query) use ($dokterId) {
            $query->where('dokter_id', $dokterId);
        })
            ->whereDate('created_at', now()->toDateString())
            ->whereNotNull('nomor_rekam_medis')
            ->count();

        $nomorUrut = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
        $nomorRM = 'RM' . $tanggal . $nomorUrut;

        $kajian->nomor_rekam_medis = $nomorRM;
        $kajian->save();

        return redirect()->back()->with('success', 'Diagnosis berhasil disimpan. Nomor Rekam Medis: ' . $nomorRM);
    }

    /**
     * Menampilkan rekam medis dengan filter tanggal dan pagination.
     */
    public function rekamMedis(Request $request)
    {
        $user = Auth::user();

        if (!$user->isDokter()) {
            abort(403, 'Akses hanya untuk dokter.');
        }

        $dokter = $user->dokter;

        if (!$dokter) {
            return back()->with('error', 'Data dokter tidak ditemukan.');
        }

        // Ambil filter tanggal dari input (optional)
        $tanggal = $request->input('tanggal');

        $query = KajianAwal::with(['pendaftaran.pasien', 'pendaftaran.dokter'])
            ->whereHas('pendaftaran', function ($q) use ($dokter) {
                $q->where('dokter_id', $dokter->id)
                    ->whereNotNull('diagnosis');
            });

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }
        // Pagination 10 data per halaman
        $rekamMedis = $query->latest()->paginate(10)->withQueryString();

        return view('dokter.rekammedis', compact('rekamMedis'));
    }

    /**
     * Update rekam medis (diagnosis & obat).
     */
    public function updateRekamMedis(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kajian_awals,id',
            'diagnosis' => 'required|string',
            'obat' => 'nullable|string',
        ]);

        $kajian = KajianAwal::findOrFail($request->id);
        $kajian->diagnosis = $request->diagnosis;
        $kajian->obat = $request->obat;
        $kajian->save();

        return redirect()->route('dokter.rekammedis')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Tampilkan data pasien yang memiliki diagnosis dan obat.
     */
    public function dataPasien()
    {
        $user = Auth::user();

        if (!$user->isDokter()) {
            abort(403, 'Akses hanya untuk dokter.');
        }

        $dokter = $user->dokter;

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan.');
        }

        $kajianAwals = KajianAwal::with('pendaftaran.pasien', 'pendaftaran.dokter')
            ->whereNotNull('diagnosis')
            ->whereNotNull('obat')
            ->whereHas('pendaftaran', function ($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->latest()
            ->paginate(10); // GANTI dari ->get() menjadi paginate

        return view('dokter.datapasien', compact('kajianAwals'));
    }

    /**
     * Update data pasien dari form edit dokter.
     */
    public function updateDataPasien(Request $request)
    {
        $request->validate([
            'kajian_id' => 'required|exists:kajian_awals,id',
            // Data Diri
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status' => 'required|string|max:50',
            // Penanggung Jawab
            'penanggung_hubungan' => 'required|string|max:100',
            'penanggung_nama' => 'required|string|max:255',
            'penanggung_alamat' => 'required|string',
            'penanggung_pekerjaan' => 'required|string|max:100',
            'penanggung_gender' => 'required|in:Laki-laki,Perempuan',
            'penanggung_agama' => 'required|string|max:50',
            'penanggung_status' => 'required|string|max:50',
            'no_whatsapp' => 'required|string|max:20',
            // Jadwal Dokter
            'tanggal_registrasi' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $kajian = KajianAwal::with('pendaftaran.pasien')->findOrFail($request->kajian_id);

            $user = Auth::user();
            if (!$user->isDokter()) {
                abort(403, 'Akses hanya untuk dokter.');
            }

            $dokter = $user->dokter;
            if ($kajian->pendaftaran->dokter_id !== $dokter->id) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit data pasien ini.');
            }

            // Update pasien
            $pasien = $kajian->pendaftaran->pasien;
            $pasien->update([
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

            // Update registrasi
            $kajian->pendaftaran->update([
                'tanggal_registrasi' => $request->tanggal_registrasi,
            ]);

            DB::commit();

            return redirect()->route('dokter.datapasien')->with('success', 'Data pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
