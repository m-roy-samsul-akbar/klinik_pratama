<?php

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

/*
|--------------------------------------------------------------------------
| Public (Guest)
|--------------------------------------------------------------------------
*/

// Auth (login/register admin)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterAdminForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman publik
Route::get('/', fn() => view('pages.home'))->name('home');
Route::get('/tentangkami', fn() => view('pages.tentangkami'))->name('tentangkami');
Route::get('/kontakkami', fn() => view('pages.kontakkami'))->name('kontakkami');
Route::get('/perhatian', fn() => view('form.perhatian'))->name('perhatian');
Route::get('/verifikasi', fn() => view('form.verifikasi'))->name('form.verifikasi');
Route::get('/cekantrian', fn() => view('pages.cekantrian'))->name('cekantrian');
Route::get('/buktipendaftaran', [PendaftaranController::class, 'buktipendaftaran'])
    ->name('bukti.pendaftaran');

// Antrian terkini (dipakai display publik)
Route::get('/admin/pendaftaran/antrian-terkini', [PendaftaranController::class, 'getAntrianTerkini'])
    ->name('antrian.terkini');

// Submit pendaftaran dari FORM PUBLIK (verifikasi)
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
    ->name('registerPendaftaran.store'); // biar kompatibel dengan action lama


/*
|--------------------------------------------------------------------------
| Protected (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Settings (profil & password)
    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    // Redirect dashboard berdasarkan role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isDokter()) return redirect()->route('dokter.dashboard');
        return redirect('/');
    })->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Admin Only
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

        // Dokter Management
        Route::resource('dokter', DokterController::class);
        Route::get('/datadokter', [DokterController::class, 'index'])->name('admin.datadokter');
        Route::put('/dokter/update-akun/{id}', [DokterController::class, 'updateAkun'])->name('dokter.updateAkun');

        // Jadwal Dokter Management
        Route::resource('jadwaldokter', JadwalDokterController::class);

        // Pendaftaran (Admin)
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran');
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('admin.pendaftaran.store');
        Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');
        Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('admin.pendaftaran.show');

        // Tandai pasien TIDAK HADIR (amankan di admin)
        Route::post('/pendaftaran/tidak-hadir', [PendaftaranController::class, 'tidakHadir'])
            ->name('pasien.tidak_hadir');

        // Data antrian & panggil pasien
        Route::get('/dataantrian', [PendaftaranController::class, 'dataAntrian'])->name('admin.dataantrian');
        Route::post('/dataantrian/panggil/{id}', [PendaftaranController::class, 'panggilPasien'])
            ->name('antrian.panggil');

        // API AJAX (Admin)
        Route::get('/api/dokter/by-spesialis/{spesialis}', [PendaftaranController::class, 'getDokterBySpesialis'])
            ->name('admin.api.dokter.by-spesialis');

        Route::get('/api/dokter/jam-praktek', function (Illuminate\Http\Request $r) {
            $dokter = \App\Models\Dokter::find($r->dokter_id);
            return response()->json(['data' => ['jam_praktek' => $dokter->jam_praktek ?? null]]);
        })->name('admin.api.dokter.jam-praktek');

        Route::post('/api/pasien/cek', [PendaftaranController::class, 'cekPasienLama'])
            ->name('admin.api.pasien.cek');

        Route::get('/api/pendaftaran/statistik', [PendaftaranController::class, 'getStatistik'])
            ->name('admin.api.pendaftaran.statistik');

        Route::get('/api/pendaftaran/export', [PendaftaranController::class, 'export'])
            ->name('admin.api.pendaftaran.export');

        // Kajian awal (perawat/admin melakukan input awal)
        Route::post('/kajian-awal', [PendaftaranController::class, 'simpanKajianAwal'])->name('kajian-awal.store');

        // Data pasien & rekam medis (tampilan admin)
        Route::get('/datapasien', [PendaftaranController::class, 'dataPasien'])->name('admin.datapasien');

        // Pengaturan admin (static view)
        Route::get('/pengaturan', fn() => view('admin.pengaturan'))->name('admin.pengaturan');
    });

    /*
    |----------------------------------------------------------------------
    | Dokter Only
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:dokter'])->prefix('dokter')->group(function () {

        // Dashboard Dokter
        Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dokter.dashboard');
        Route::get('/dashboard/data', [DashboardDokterController::class, 'getRealtimeData'])->name('dashboard.realtime');

        // Laporan Dokter
        Route::get('/laporan', [LaporanController::class, 'index'])->name('dokter.laporan');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

        // Kajian & Rekam Medis (untuk dokter)
        Route::get('/kajian-awal', [KajianController::class, 'kajianAwalPasien'])->name('dokter.kajian.index');
        Route::post('/kajian-awal', [KajianController::class, 'simpanDiagnosis'])->name('dokter.kajian.update');

        Route::get('/rekammedis', [KajianController::class, 'rekamMedis'])->name('rekammedis.index');
        Route::put('/rekammedis', [KajianController::class, 'updateRekamMedis'])->name('rekammedis.update');

        Route::get('/data-pasien', [KajianController::class, 'dataPasien'])->name('dokter.datapasien');
        Route::put('/data-pasien/update', [KajianController::class, 'updateDataPasien'])->name('dokter.datapasien.update');
        Route::delete('/data-pasien/hapus/{id}', [KajianController::class, 'hapusDataPasien'])->name('datapasien.hapus');
    });

});
