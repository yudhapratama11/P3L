<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartProcurementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart_procurement_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_sparepart');
            $table->foreign('id_sparepart')
                  ->references('id')->on('spareparts');
            $table->unsignedInteger('id_sparepart_procurement');
            $table->foreign('id_sparepart_procurement')
                  ->references('id')->on('sparepart_procurements');
            $table->integer('jumlah');
            $table->double('satuan_harga');
            $table->double('subtotal');
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
        Schema::dropIfExists('sparepart_procurement_details');
    }
}
