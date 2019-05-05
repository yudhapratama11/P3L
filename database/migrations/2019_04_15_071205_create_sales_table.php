<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nomor_telepon');
            $table->unsignedInteger('id_supplier');
            $table->foreign('id_supplier')
                  ->references('id')->on('suppliers')
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
        Schema::table('Sales', function (Blueprint $table) {
            //
        });
    }
}
