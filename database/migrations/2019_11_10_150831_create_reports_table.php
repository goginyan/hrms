<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reports', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('title');
			$table->json('fields');
			$table->boolean('has_chart')->default(false);
			$table->string('order_column')->default('id');
			$table->enum('ordering', ['asc', 'desc'])->default('asc');
			$table->unsignedInteger('survey_id')->nullable()->default(null);
			$table->timestamps();

			$table->foreign('survey_id')
			      ->on('surveys')
			      ->references('id')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('reports');
	}
}
