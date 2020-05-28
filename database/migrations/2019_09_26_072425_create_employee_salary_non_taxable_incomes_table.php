<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSalaryNonTaxableIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_non_taxable_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_salary_id');
            $table->unsignedInteger('non_taxable_income_id');
            $table->double('amount');
            $table->timestamps();

            $table->foreign('employee_salary_id', 'es_id_foreign')
                ->references('id')
                ->on('employee_salaries')
                ->onDelete('cascade');
            $table->foreign('non_taxable_income_id', 'nti_id_foreign')
                ->references('id')
                ->on('non_taxable_incomes')
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
        Schema::dropIfExists('employee_salary_non_taxable_incomes');
    }
}
