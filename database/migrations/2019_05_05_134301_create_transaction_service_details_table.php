<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionServiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_service_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transaction');
            $table->foreign('id_transaction')
                  ->references('id')->on('transactions');
            $table->unsignedInteger('id_service');
            $table->foreign('id_service')
            ->references('id')->on('services')
            ->onDelete('cascade');
            $table->unsignedInteger('id_customer_motorcycle');
            $table->foreign('id_customer_motorcycle')
            ->references('id')->on('customers_motorcycle')
            ->onDelete('cascade');
            $table->unsignedInteger('id_montir_onduty');
            $table->foreign('id_montir_onduty')
            ->references('id')->on('employees')
            ->onDelete('cascade');
            $table->integer('status_montir_onduty');
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
        Schema::dropIfExists('transaction_service_details');
    }
}
