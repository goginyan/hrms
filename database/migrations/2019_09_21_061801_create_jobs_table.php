<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('vacancies', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('position');
			$table->string('location')->nullable();
			$table->string('duration')->nullable();
			$table->string('work_type')->nullable();
			$table->text('description')->nullable();
			$table->text('responsibilities')->nullable();
			$table->text('qualifications')->nullable();
			$table->date('open_date')->nullable();
			$table->date('end_date')->nullable();
			$table->string('application_procedure')->nullable();
			$table->unsignedInteger('contact_person_id')->nullable();
			$table->integer('salary')->nullable();
			$table->string('salary_currency')->nullable();
			$table->string('contact_email')->nullable();
			$table->boolean('with_form')->default(false);
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
			$table->string('education')->nullable();
			$table->string('work_experience')->nullable();
			$table->string('achievements')->nullable();
			$table->string('certificates')->nullable();
			$table->string('skills')->nullable();
			$table->string('languages')->nullable();
			$table->string('interests')->nullable();
			$table->string('attach_cv')->nullable();
			$table->string('cover_letter')->nullable();
			$table->string('linked_in')->nullable();
			$table->boolean('published')->default(true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('contact_person_id')
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
		Schema::dropIfExists('vacancies');
	}
}
