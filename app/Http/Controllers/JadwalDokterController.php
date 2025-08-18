<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    /**
     * Fungsi untuk mengurutkan hari sesuai urutan Senin–Minggu
     */
    private function urutkanHari(array $hariArray): array
    {
        $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return array_values(array_intersect($urutanHari, $hariArray));
    }

    public function index(Request $request)
    {
        // Ambil semua dokter
        $dokterQuery = Dokter::query();

        // Filter per poli jika dipilih
        if ($request->filled('spesialis')) {
            $dokterQuery->where('spesialis', $request->spesialis);
        }

        $dokters = $dokterQuery->get();

        // Ambil jadwal dokter sesuai filter poli
        $jadwalQuery = JadwalDokter::with('dokter');

        if ($request->filled('spesialis')) {
            $jadwalQuery->whereHas('dokter', function ($q) use ($request) {
                $q->where('spesialis', $request->spesialis);
            });
        }

        // Pagination 5 data per halaman
        $jadwals = $jadwalQuery->paginate(5);

        return view('admin.jadwaldokter', compact('jadwals', 'dokters'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $hariArray = explode(',', $request->hari);
        $hariArray = array_map('trim', $hariArray);

        if (in_array('Setiap Hari', $hariArray)) {
            $hariArray = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        }

        $validHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hariArray = array_intersect($hariArray, $validHari);
        $hariArray = $this->urutkanHari($hariArray);

        if (empty($hariArray)) {
            return redirect()->back()->with('error', 'Pilih minimal satu hari yang valid.');
        }

        $existingJadwal = JadwalDokter::where('dokter_id', $request->dokter_id)->first();
        if ($existingJadwal) {
            $existingHari = $existingJadwal->hari ?? [];
            $mergedHari = array_unique(array_merge($existingHari, $hariArray));
            $orderedHari = $this->urutkanHari($mergedHari);

            $existingJadwal->update([
                'hari' => $orderedHari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
        } else {
            JadwalDokter::create([
                'dokter_id' => $request->dokter_id,
                'hari' => $hariArray,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
        }

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string',
        ]);

        $jadwal = JadwalDokter::findOrFail($id);

        $hariArray = explode(',', $request->hari);
        $hariArray = array_map('trim', $hariArray);

        if (in_array('Setiap Hari', $hariArray)) {
            $hariArray = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        }

        $validHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hariArray = array_intersect($hariArray, $validHari);
        $hariArray = $this->urutkanHari($hariArray);

        if (empty($hariArray)) {
            return redirect()->back()->with('error', 'Pilih minimal satu hari yang valid.');
        }

        $jadwal->update([
            'dokter_id' => $request->dokter_id,
            'hari' => $hariArray
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
