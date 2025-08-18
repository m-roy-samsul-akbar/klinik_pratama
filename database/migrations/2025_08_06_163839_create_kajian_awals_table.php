<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kajian_awals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained()->onDelete('cascade');
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('cascade');
            $table->string('suhu_tubuh');
            $table->string('tekanan_darah');
            $table->integer('tinggi_badan');
            $table->float('berat_badan');
            $table->text('keluhan');
            $table->text('diagnosis')->nullable();              // diagnosis dokter
            $table->text('obat')->nullable();                   // resep/obat
            $table->string('nomor_rekam_medis')->nullable();    // nomor rekam medis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kajian_awals');
    }
};
