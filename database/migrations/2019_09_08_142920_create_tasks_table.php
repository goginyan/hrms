<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tasks', function( Blueprint $table ) {
			$table->increments('id');
			$table->unsignedInteger('author_id');
			$table->unsignedInteger('assignee_id')->nullable();
			$table->string('assignee_type')->nullable();
			$table->string('title');
			$table->text('description');
			$table->json('attachments')->nullable();
			$table->enum('type', ['task', 'bug', 'feature'])->default('task');
			$table->enum('status', [
				'new',
				'confirmed',
				'in_process',
				'in_testing',
				'test_failed',
				'done',
				'closed',
			])->default('new');
			$table->enum('priority', ['normal', 'low', 'high', 'urgent'])->default('normal');
			$table->timestamp('started_at')->nullable();
			$table->timestamp('finished_at')->nullable();
			$table->timestamp('deadline')->nullable();
			$table->integer('duration')->nullable();
			$table->unsignedInteger('responsible_id')->nullable();
			$table->unsignedInteger('parent_id')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('author_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('assignee_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('responsible_id')
			      ->references('id')
			      ->on('employees');
			$table->foreign('parent_id')
			      ->references('id')
			      ->on('tasks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tasks');
	}
}
