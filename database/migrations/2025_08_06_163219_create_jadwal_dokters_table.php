<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalDoktersTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade'); // relasi ke tabel dokters
            $table->json('hari');               // simpan array hari dalam format JSON
            $table->time('jam_mulai');          // jam mulai praktek
            $table->time('jam_selesai');        // jam selesai praktek
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_dokters');
    }
}

