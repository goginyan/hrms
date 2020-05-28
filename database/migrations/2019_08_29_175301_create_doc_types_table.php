<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocTypesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('doc_types', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->string('display_name');
			$table->unsignedInteger('author_id');
			$table->timestamps();

			$table->foreign('author_id')
			      ->references('id')
			      ->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('doc_types');
	}
}
