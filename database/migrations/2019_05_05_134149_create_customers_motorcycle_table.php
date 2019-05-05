<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersMotorcycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_motorcycle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plat');
            $table->unsignedInteger('id_motorcycle_type');
            $table->foreign('id_motorcycle_type')
            ->references('id')->on('motorcycle_types')
            ->onDelete('cascade');
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
        Schema::dropIfExists('customers_motorcycle');
    }
}
