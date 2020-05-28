<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicantsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('job_applicants', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('patronymic')->nullable();
			$table->string('photo')->nullable();
			$table->string('sex')->nullable();
			$table->string('family_status')->nullable();
			$table->string('nationality')->nullable();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('email')->nullable();
			$table->text('education')->nullable();
			$table->text('work_experience')->nullable();
			$table->text('achievements')->nullable();
			$table->text('certificates')->nullable();
			$table->text('skills')->nullable();
			$table->text('languages')->nullable();
			$table->text('interests')->nullable();
			$table->string('attach_cv')->nullable();
			$table->string('cover_letter')->nullable();
			$table->string('linked_in')->nullable();
			$table->unsignedInteger('vacancy_id');
			$table->enum('status', [
				'applicant',
				'candidate',
				'invited',
				'pending',
				'intern',
				'inappropriate'
			])->default('applicant');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('vacancy_id')
			      ->references('id')
			      ->on('vacancies');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('job_applicants');
	}
}
