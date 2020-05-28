<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionQuizTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('question_quiz', function( Blueprint $table ) {
			$table->unsignedInteger('quiz_id');
			$table->unsignedInteger('question_id');
			$table->integer('sort_order');

			$table->primary(['quiz_id', 'question_id']);

			$table->foreign('quiz_id')
			      ->references('id')
			      ->on('quizzes');
			$table->foreign('question_id')
			      ->references('id')
			      ->on('questions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('question_quiz');
	}
}
