<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->string('merk');
            $table->double('harga_beli');
            $table->double('harga_jual');
            $table->integer('stok');
            $table->integer('stok_minimal');
            $table->string('penempatan');
            $table->string('gambar')->nullable();
            $table->unsignedInteger('id_sparepart_type');
            $table->foreign('id_sparepart_type')
            ->references('id')->on('sparepart_types')
            ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spareparts');
    }
}
