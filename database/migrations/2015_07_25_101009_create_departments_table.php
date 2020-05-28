<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

	        $table->foreign('parent_id')
	              ->references('id')
	              ->on('departments')
	              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
