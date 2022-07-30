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
        Schema::create('langganans', function (Blueprint $table) {
            $table->increments('id_langganan');
            $table->integer('pelanggan_id')->nullable()->unsigned();
            $table->foreign('pelanggan_id')->references('id_user')->on('users');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id_layanan')->on('layanans')->onDelete ('cascade'); //->onDelete ('cascade');
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
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id_status')->on('status');
            $table->timestamp('tgl_aktif')->nullable();
            $table->timestamp('tgl_lanjut')->nullable();
            $table->integer('bts_id')->nullable()->unsigned();
            $table->foreign('bts_id')->references('id_bts')->on('bts');
            $table->integer('turunan_id')->nullable()->unsigned();
            $table->foreign('turunan_id')->references('id_turunan')->on('turunan_bts');
            $table->string('ip')->nullable();
            $table->string('ip_radio')->nullable();
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
        Schema::dropIfExists('langganans');
    }
};
