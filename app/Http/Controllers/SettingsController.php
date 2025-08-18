<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{

    public function index()
    {
        return view('dokter.pengaturan');
    }
    public function updateProfile(Request $request)
    {
        // ✅ Validasi input terlebih dahulu
        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $user = Auth::user();

        // Simpan file jika diupload
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            // Auto-generate filename dan simpan ke storage/app/public/foto_profil
            $filename = $file->store('foto_profil', 'public'); // ✅ Lebih singkat dan aman

            // Simpan path-nya ke database tanpa 'public/'
            $user->foto_profil = $filename;
        }

        //  Update nama & email
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->refresh();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diganti.');
    }
}
