<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('agama');
            $table->text('alamat');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('status');
            $table->string('penanggung_hubungan');
            $table->string('penanggung_nama');
            $table->text('penanggung_alamat');
            $table->string('penanggung_pekerjaan');
            $table->enum('penanggung_gender', ['Laki-laki', 'Perempuan']);
            $table->string('penanggung_agama');
            $table->string('penanggung_status');
            $table->string('no_whatsapp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
};