<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('interviews', function( Blueprint $table ) {
			$table->increments('id');
			$table->timestamp('planned_at');
			$table->unsignedInteger('organizer_id')->nullable();
			$table->unsignedInteger('vacancy_id')->nullable();
			$table->unsignedInteger('applicant_id')->nullable();
			$table->text('comment')->nullable();
			$table->enum('status', ['active', 'pending', 'done'])->default('active');
			$table->timestamps();

			$table->foreign('organizer_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('vacancy_id')
			      ->references('id')
			      ->on('vacancies')
			      ->onDelete('cascade');
			$table->foreign('applicant_id')
			      ->references('id')
			      ->on('job_applicants')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('interviews');
	}
}
