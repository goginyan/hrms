<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('documents', function( Blueprint $table ) {
			$table->increments('id');
			$table->unsignedInteger('author_id');
			$table->unsignedInteger('type_id')->nullable();
			$table->unsignedInteger('waiting_id')->nullable();
			$table->json('fields');
			$table->boolean('approved')->default(false);
			$table->text('comment')->nullable();
			$table->unsignedInteger('rejected_by')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('author_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('rejected_by')
			      ->references('id')
			      ->on('employees');
			$table->foreign('waiting_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('type_id')
			      ->references('id')
			      ->on('doc_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('documents');
	}
}
