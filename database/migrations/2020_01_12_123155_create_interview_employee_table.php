<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewEmployeeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_interview', function( Blueprint $table ) {
			$table->unsignedInteger('interview_id');
			$table->unsignedInteger('employee_id');
			$table->integer('feedback_rate')->nullable();
			$table->text('feedback_comment')->nullable();

			$table->primary(['employee_id', 'interview_id']);

			$table->foreign('employee_id')
			      ->references('id')
			      ->on('employees')
			      ->onDelete('cascade');
			$table->foreign('interview_id')
			      ->references('id')
			      ->on('interviews')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employee_interview');
	}
}
