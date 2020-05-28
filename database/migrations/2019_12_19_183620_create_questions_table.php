<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('text');
			$table->enum('type', ['text', 'radio', 'checkbox', 'range']);
			$table->json('answers')->nullable();
			$table->json('right_answers')->nullable();
			$table->unsignedInteger('survey_id')->nullable();
			$table->timestamps();

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
		Schema::dropIfExists('questions');
	}
}
