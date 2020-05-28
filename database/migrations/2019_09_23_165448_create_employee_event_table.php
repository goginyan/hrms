<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEventTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_event', function( Blueprint $table ) {
			$table->unsignedInteger('event_id');
			$table->unsignedInteger('employee_id');

			$table->primary(['event_id', 'employee_id']);

			$table->foreign('event_id')
			      ->references('id')
			      ->on('events')
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
		Schema::dropIfExists('employee_event');
	}
}
