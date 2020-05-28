<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSalaryTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_salary_id');
            $table->unsignedInteger('tax_id');
            $table->double('amount');
            $table->timestamps();

            $table->foreign('employee_salary_id')
                ->references('id')
                ->on('employee_salaries')
                ->onDelete('cascade');
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salary_taxes');
    }
}
