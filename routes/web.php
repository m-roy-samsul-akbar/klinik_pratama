<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\SettingsController;

// Authentication Routes login dan register (dokter & admin)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterAdminForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/kirimPendaftaran', [RegisterController::class, 'store'])->name('registerPendaftaran.store');

// Public User Pasien
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/tentangkami', function () {
    return view('pages.tentangkami');
})->name('tentangkami');

Route::get('/kontakkami', function () {
    return view('pages.kontakkami');
})->name('kontakkami');

Route::get('/perhatian', function () {
    return view('form.perhatian');
})->name('perhatian');

Route::get('/verifikasi', function () {
    return view('form.verifikasi');
})->name('form.verifikasi');

Route::get('/verifikasi2', function () {
    return view('form.verifikasi2');
})->name('form.verifikasi2');

Route::get('/data', function () {
    return view('form.data');
})->name('data');

Route::get('/otp', function () {
    return view('form.otp');
})->name('otp');

Route::get('/cekantrian', function () {
    return view('pages.cekantrian');
})->name('cekantrian');

Route::get('/buktipendaftaran', function () {
    return view('pages.buktipendaftaran');
})->name('buktipendaftaran');

Route::get('/admin/pendaftaran/antrian-terkini', [PendaftaranController::class, 'getAntrianTerkini'])
    ->name('antrian.terkini');


// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {

    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings.index');
    // Settings - Update Profile dan Ganti Password
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    // General Dashboard Route (redirects based on role)
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDokter()) {
            return redirect()->route('dokter.dashboard');
        }

        return redirect('/');
    })->name('dashboard');

    // Admin Dashboard - Only Admin Role
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');


        // Dokter Management
        Route::resource('dokter', DokterController::class);

        Route::get('/datadokter', [DokterController::class, 'index'])->name('admin.datadokter');

        Route::put('/dokter/update-akun/{id}', [DokterController::class, 'updateAkun'])->name('dokter.updateAkun');


        // Jadwal Dokter Management
        Route::resource('jadwaldokter', JadwalDokterController::class);

        // Pendaftaran Pasien Management
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran');
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('admin.pendaftaran.store');
        Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');
        Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('admin.pendaftaran.show');


        // API Routes for AJAX calls
        Route::get('/api/dokter/by-spesialis/{spesialis}', [PendaftaranController::class, 'getDokterBySpesialis'])
            ->name('admin.api.dokter.by-spesialis');
        Route::post('/api/pasien/cek', [PendaftaranController::class, 'cekPasienLama'])
            ->name('admin.api.pasien.cek');

        // Additional API routes
        Route::get('/api/pendaftaran/statistik', [PendaftaranController::class, 'getStatistik'])
            ->name('admin.api.pendaftaran.statistik');
        Route::get('/api/pendaftaran/export', [PendaftaranController::class, 'export'])
            ->name('admin.api.pendaftaran.export');

        Route::post('/kajian-awal', [PendaftaranController::class, 'simpanKajianAwal'])->name('kajian-awal.store');
        // Route::get('/rekammedis', [PendaftaranController::class, 'rekamMedis'])->name('rekammedis.index');
        Route::get('/datapasien', [PendaftaranController::class, 'dataPasien'])->name('admin.datapasien');

        // Route untuk memanggil pasien
        Route::post('/admin/dataantrian/panggil/{id}', [PendaftaranController::class, 'panggilPasien'])->name('antrian.panggil');

        // Other admin routes

        Route::get('/dataantrian', [PendaftaranController::class, 'dataAntrian'])->name('admin.dataantrian');

        Route::get('/pengaturan', function () {
            return view('admin.pengaturan');
        })->name('admin.pengaturan');

    });

    // Dokter Dashboard - Only Dokter Role
    Route::middleware(['role:dokter'])->prefix('dokter')->group(function () {
        // 

        Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/data', [DashboardDokterController::class, 'getRealtimeData'])->name('dashboard.realtime');

        Route::get('/dashboard', function () {
            return view('dokter.dashboard');
        })->name('dokter.dashboard');

        Route::get('/laporan', function () {
            return view('dokter.laporan');
        })->name('dokter.laporan');

        Route::get('/pengaturan', function () {
            return view('dokter.pengaturan');
        })->name('dokter.pengaturan');


        Route::put('/data-pasien/update', [KajianController::class, 'updateDataPasien'])->name('dokter.datapasien.update');
        Route::delete('/data-pasien/hapus/{id}', [KajianController::class, 'hapusDataPasien'])->name('datapasien.hapus');
        Route::get('/data-pasien', [KajianController::class, 'dataPasien'])->name('dokter.datapasien');
        Route::get('/rekammedis', [KajianController::class, 'rekamMedis'])->name('rekammedis.index');
        Route::put('/rekammedis', [KajianController::class, 'updateRekamMedis'])->name('rekammedis.update');
        Route::get('/kajian-awal', [KajianController::class, 'kajianAwalPasien'])->name('dokter.kajian.index');
        Route::post('/kajian-awal', [KajianController::class, 'simpanDiagnosis'])->name('dokter.kajian.update');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('dokter.laporan');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    });

});