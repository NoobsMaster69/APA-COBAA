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
        Schema::create('ProdukJadi', function (Blueprint $table) {
            $table->string('kd_produk', 10)->primary();
            $table->string('nm_produk', 50);
            $table->integer('stok');
            $table->string('kd_satuan', 10);
            $table->integer('harga_jual');
            $table->string('ket');
            $table->text('foto');

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
        Schema::dropIfExists('ProdukJadi');
    }
};
