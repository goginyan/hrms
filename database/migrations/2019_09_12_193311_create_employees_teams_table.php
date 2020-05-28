<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTeamsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_team', function( Blueprint $table ) {
			$table->unsignedInteger('team_id');
			$table->unsignedInteger('employee_id');
			$table->string('role')->default('member');

			$table->primary(['team_id', 'employee_id']);
			$table->foreign('team_id')
			      ->references('id')
			      ->on('teams')
			      ->onDelete('cascade');
			$table->foreign('employee_id')
			      ->references('id')
			      ->on('employees')
			      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employee_team');
	}
}
