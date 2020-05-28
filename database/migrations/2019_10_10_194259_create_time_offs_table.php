<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeOffsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('time_offs', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('type');
			$table->boolean('paid');
			$table->text('reason')->nullable();
			$table->timestamp('started_at');
			$table->timestamp('finished_at');
			$table->boolean('approved')->default(false);
			$table->unsignedInteger('employee_id');
			$table->timestamps();

			$table->foreign('employee_id')
			      ->on('employees')
			      ->references('id')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('time_offs');
	}
}
