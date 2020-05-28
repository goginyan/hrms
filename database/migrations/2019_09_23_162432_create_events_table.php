<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('events', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('title');
			$table->timestamp('start_date');
			$table->timestamp('end_date')->nullable();
			$table->string('location');
			$table->text('description')->nullable();
			$table->string('file')->nullable();
			$table->boolean('reminder')->default(false);
			$table->unsignedInteger('creator_id')->nullable();
			$table->timestamps();

			$table->foreign('creator_id')
			      ->references('id')
			      ->on('employees');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('events');
	}
}
