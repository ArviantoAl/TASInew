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
        Schema::create('langganan_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_id');
            $table->foreign('invoice_id')->references('id_invoice')->on('invoices');
            $table->integer('pelanggan_id')->unsigned();
            $table->foreign('pelanggan_id')->references('id_user')->on('users');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id_layanan')->on('layanans')->onDelete ('cascade');
            $table->integer('langganan_id')->unsigned();
            $table->foreign('langganan_id')->references('id_langganan')->on('langganans');
            $table->integer('harga_satuan');
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
        Schema::dropIfExists('langganan_invoices');
    }
};
