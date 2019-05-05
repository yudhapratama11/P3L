<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorySparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_sparepart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_sparepart');
            $table->foreign('id_sparepart')
                  ->references('id')->on('spareparts');
            $table->timestamp('tanggal');
            $table->integer('jumlah');
            $table->double('satuan_harga');
            $table->double('subtotal');
            $table->integer('status');
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
        Schema::dropIfExists('history_sparepart');
    }
}
