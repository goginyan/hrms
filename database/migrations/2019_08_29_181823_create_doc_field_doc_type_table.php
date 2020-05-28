<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocFieldDocTypeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('doc_field_doc_type', function( Blueprint $table ) {
			$table->unsignedInteger('doc_type_id');
			$table->unsignedInteger('doc_field_id');
			$table->string('field_name');
			$table->integer('order');

			$table->primary(['doc_field_id', 'doc_type_id', 'field_name']);

			$table->foreign('doc_field_id')
			      ->references('id')
			      ->on('doc_fields')
			      ->onDelete('cascade');
			$table->foreign('doc_type_id')
			      ->references('id')
			      ->on('doc_types')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('doc_field_doc_type');
	}
}
