<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizablesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('quizables', function( Blueprint $table ) {
            $table->unsignedInteger('quiz_id');
            $table->unsignedInteger('quizable_id');
            $table->string('quizable_type');
            $table->integer('result')->nullable();
            $table->text('token')->nullable();
            $table->json('details')->nullable();

            $table->primary(['quiz_id', 'quizable_id', 'quizable_type']);

            $table->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('quizables');
	}
}
