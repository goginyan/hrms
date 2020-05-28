<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employees', function( Blueprint $table ) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('department_id')->unsigned()->nullable();
			$table->string('first_name');
			$table->string('last_name');
			$table->longText('avatar')->nullable();
			$table->string('patronymic')->nullable();
			$table->string('social_in')->nullable();
			$table->string('social_fb')->nullable();
			$table->string('social_tw')->nullable();
			$table->date('birth_date')->nullable();
			$table->enum('sex', ['male', 'female'])->nullable();
			$table->string('phone_number')->nullable();
			$table->enum('status', ['full', 'part', 'intern', 'remote'])->default('full');
			$table->string('nationality')->nullable();
			$table->string('citizenship')->nullable();
			$table->string('residence_address')->nullable();
			$table->string('registration_address')->nullable();
			$table->double('salary')->default(0);
			$table->float('paid_time', 8, 2)->default(0);
			$table->float('unpaid_time', 8, 2)->default(0);
			$table->timestamp('vacation_expire')->nullable();
			$table->integer('reward_received')->default(0);
			$table->integer('reward_monthly')->default(0);
			$table->integer('reward_left')->default(100);
			$table->unsignedInteger('manager_id')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')
			      ->references('id')
			      ->on('users')
			      ->onDelete('cascade')
			      ->onUpdate('cascade');
			$table->foreign('department_id')
			      ->references('id')
			      ->on('departments');
			$table->foreign('manager_id')
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
		Schema::dropIfExists('employees');
	}
}
