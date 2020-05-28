<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('education', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->enum('degree', ['bachelor', 'master', 'phd'])->nullable();
			$table->string('department')->nullable();
			$table->string('specialization');
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
		Schema::dropIfExists('education');
	}
}
