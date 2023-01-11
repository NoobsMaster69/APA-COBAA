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
        Schema::create('databahan', function (Blueprint $table) {
            // menjadikan kolom kd_bahan sebagai primary key tipe string
            $table->string('kd_bahan', 10)->primary();
            $table->string('nm_bahan', 50);
            $table->string('kd_satuan', 10);
            $table->integer('harga_beli');
            $table->integer('stok');
            $table->string('ket');
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
        Schema::dropIfExists('databahan');
    }
};
