<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRedeemableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_redeemable', function (Blueprint $table) {
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('redeemable_id');
            $table->timestamp('date')->nullable();

            $table->primary(['employee_id', 'redeemable_id', 'date']);

            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees');
            $table->foreign('redeemable_id')
                  ->references('id')
                  ->on('redeemables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_redeemable');
    }
}
