<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileFormFieldsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('profile_form_fields', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('column')->nullable();
			$table->string('form_name')->unique()->default('_');
			$table->string('label')->unique();
			$table->boolean('active')->default(true);
			$table->boolean('required')->default(true);
			$table->boolean('is_protected')->default(false);
			$table->unsignedInteger('type_id')->default(1);
			$table->timestamps();

			$table->foreign('type_id')
			      ->references('id')
			      ->on('doc_fields');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('profile_form_fields');
	}
}
