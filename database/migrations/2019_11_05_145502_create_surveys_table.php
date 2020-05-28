<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('surveys', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->unsignedInteger('author_id')->nullable();
			$table->boolean('active')->default(false);
			$table->timestamp('expired_at')->nullable();
			$table->timestamps();

			$table->foreign('author_id')
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
		Schema::dropIfExists('surveys');
	}
}
