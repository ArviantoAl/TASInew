<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bts', function (Blueprint $table) {
            $table->increments('id_bts');
            $table->string('nama_bts');
            $table->integer('kategori_id')->unsigned();
            $table->foreign('kategori_id')->references('id_kategori')->on('kategoris');
            $table->integer('jenis_id')->unsigned();
            $table->foreign('jenis_id')->references('id_jenis')->on('jenis_bts');
            $table->char('provinsi_id');
            $table->foreign('provinsi_id')->references('id')->on('provinces');
            $table->char('kabupaten_id');
            $table->foreign('kabupaten_id')->references('id')->on('regencies');
            $table->char('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('districts');
            $table->char('desa_id');
            $table->foreign('desa_id')->references('id')->on('villages');
            $table->longText('detail_alamat');
            $table->longText('alamat_pasang')->nullable(); //untuk di implode jadi satu
            $table->string('frekuensi');
            $table->string('ssid');
            $table->string('ip');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id_status')->on('status');
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
        Schema::dropIfExists('bts');
    }
};
