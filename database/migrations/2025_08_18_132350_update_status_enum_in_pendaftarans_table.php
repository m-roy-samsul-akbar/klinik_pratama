<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pendaftarans MODIFY status 
            ENUM('Belum Kajian Awal', 'Selesai', 'Dalam Perawatan', 'Tidak Hadir') 
            DEFAULT 'Belum Kajian Awal'");
    }

    public function down(): void
    {
        // Balik ke enum sebelumnya (tanpa 'Tidak Hadir')
        DB::statement("ALTER TABLE pendaftarans MODIFY status 
            ENUM('Belum Kajian Awal', 'Selesai', 'Dalam Perawatan') 
            DEFAULT 'Belum Kajian Awal'");
    }
};