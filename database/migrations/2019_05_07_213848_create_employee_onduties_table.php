<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeOndutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_onduties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_employee');
            $table->foreign('id_employee')
                  ->references('id')
                  ->on('employees')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('id_transaction');
            $table->foreign('id_transaction')
                  ->references('id')
                  ->on('transactions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('employee_onduties');
    }
}
