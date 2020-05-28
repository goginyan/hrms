<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileFormFieldEmployeeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_profile_form_field', function( Blueprint $table ) {
			$table->unsignedInteger('profile_form_field_id');
			$table->unsignedInteger('employee_id');
			$table->text('data')->nullable();

			$table->primary(['profile_form_field_id', 'employee_id'], 'field_employee_id');

			$table->foreign('profile_form_field_id')
			      ->references('id')
			      ->on('profile_form_fields')
			      ->onDelete('cascade');
			$table->foreign('employee_id')
			      ->references('id')
			      ->on('employees')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employee_profile_form_field');
	}
}
