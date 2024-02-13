<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik');
            $table->string('no_hp');
            $table->string('sasaran');
            $table->time('waktu');
            $table->date('tgl_pengaduan');
            $table->integer('id_kecamatan');
            $table->integer('id_jenis');
            $table->string('status');
            $table->string('temuan');
            $table->string('tindakan');
            $table->string('keterangan');
            $table->string('upload_foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
}
