<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('blog_posts', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('title');
			$table->text('text');
			$table->string('image')->nullable();
			$table->unsignedInteger('author_id');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('author_id')
			      ->on('employees')
			      ->references('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('blog_posts');
	}
}
