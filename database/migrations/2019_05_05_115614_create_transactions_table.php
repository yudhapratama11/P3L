<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamp('tanggal');
            $table->integer('status');
            $table->integer('status_paid');
            $table->integer('id_transaction_type');
            $table->unsignedInteger('id_customer');
            $table->foreign('id_customer')
                  ->references('id')->on('customers')
                  ->onDelete('cascade');
            $table->double('discount');
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
        Schema::dropIfExists('transactions');
    }
}
