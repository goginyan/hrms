<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocTypeRoleTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('doc_type_role', function( Blueprint $table ) {
			$table->unsignedInteger('doc_type_id');
//			$table->morphs('role'); // Adds unsigned BIGINTEGER role_id and STRING role_type
			$table->unsignedInteger('role_id');
			$table->string('role_type');
			$table->integer('sequence')->default(1);

			$table->primary(['doc_type_id', 'role_id', 'role_type']);

			$table->foreign('role_id')
			      ->references('id')
			      ->on('roles')
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
		Schema::dropIfExists('doc_type_role');
	}
}
