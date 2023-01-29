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
        Schema::create('PengirimanProduk', function (Blueprint $table) {
            $table->increments('id_pengirimanProduk');
            $table->string('kd_produk', 10);
            $table->date('tgl_pengiriman');
            $table->integer('id_produkKeluar');
            $table->string('kd_sopir', 10);
            $table->string('kd_mobil', 10);
            $table->integer('status');
            $table->text('butki_foto');
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
        Schema::dropIfExists('PengirimanProduk');
    }
};
