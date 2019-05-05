<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSparepartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('transaction_sparepart_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transaction');
            $table->foreign('id_transaction')
                  ->references('id')->on('transactions');
            $table->string('id_sparepart');
            $table->foreign('id_sparepart')
                  ->references('id')->on('spareparts');
            $table->integer('jumlah');
            $table->double('harga_satuan');
            $table->double('subtotal');
            $table->softDeletes();
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
        Schema::dropIfExists('transaction_sparepart_details');
    }
}
