<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::with('user');

        // Filter Poli jika dipilih
        if ($request->filled('spesialis')) {
            $query->where('spesialis', $request->spesialis);
        }

        // Gunakan pagination untuk batasi 5 data per halaman
        $dokters = $query->paginate(5);

        // Ambil semua user role dokter
        $users = User::whereHas('role', function ($q) {
            $q->where('name', 'dokter');
        })->get();

        return view('admin.datadokter', compact('dokters', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'spesialis' => 'required|string',
            'telepon' => 'required|string|max:15',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek atau buat role "dokter" dengan lengkap
        $role = Role::firstOrCreate(
            ['name' => 'dokter'],
            [
                'display_name' => 'Dokter',
                'description' => 'Dokter yang bertugas di klinik'
            ]
        );

        // Buat user dokter
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $role->id,
            'phone' => $request->telepon,
        ]);

        // Buat data dokter
        Dokter::create([
            'user_id' => $user->id,
            'nama' => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'spesialis' => $request->spesialis,
            'telepon' => $request->telepon,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->back()->with('success', 'Akun dan data dokter berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
            'spesialis' => 'required',
            'telepon' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $dokter = Dokter::findOrFail($id);
        $dokter->update($request->all());

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->back()->with('success', 'Data dokter berhasil dihapus!');
    }

    public function updateAkun(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Akun pengguna dokter berhasil diperbarui.');
    }

}
