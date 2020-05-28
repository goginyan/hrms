<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('experiences', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->string('position');
			$table->string('description')->nullable();
			$table->timestamp('date_from');
			$table->timestamp('date_to')->nullable();
			$table->unsignedInteger('employee_id');
			$table->timestamps();

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
		Schema::dropIfExists('experiences');
	}
}
