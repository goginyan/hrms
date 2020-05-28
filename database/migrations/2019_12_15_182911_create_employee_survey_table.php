<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSurveyTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_survey', function( Blueprint $table ) {
			$table->unsignedInteger('employee_id');
			$table->unsignedInteger('survey_id');
			$table->enum('status', ['active', 'expired', 'done']);

			$table->primary(['employee_id', 'survey_id']);

			$table->foreign('employee_id')
			      ->references('id')
			      ->on('employees')
			      ->onDelete('cascade');
			$table->foreign('survey_id')
			      ->references('id')
			      ->on('surveys')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employee_survey');
	}
}
