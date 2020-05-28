<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_question', function (Blueprint $table) {
	        $table->unsignedInteger('employee_id');
	        $table->unsignedInteger('question_id');
	        $table->text('answer');

	        $table->primary(['employee_id', 'question_id']);

	        $table->foreign('employee_id')
	              ->references('id')
	              ->on('employees');
	        $table->foreign('question_id')
	              ->references('id')
	              ->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_question');
    }
}
