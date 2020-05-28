<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeTrackersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('time_trackers', function( Blueprint $table ) {
			$table->increments('id');
			$table->text('comment')->nullable();
			$table->timestamp('finished_at')->nullable();
			$table->integer('duration')->default(0);
			$table->unsignedInteger('employee_id');
			$table->unsignedInteger('task_id')->nullable();
			$table->timestamps();

			$table->foreign('employee_id')
			      ->references('id')
			      ->on('employees')
			      ->onDelete('cascade');
			$table->foreign('task_id')
			      ->references('id')
			      ->on('tasks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('time_trackers');
	}
}
