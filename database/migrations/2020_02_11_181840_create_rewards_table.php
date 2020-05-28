<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->unsignedInteger('recognizer_id');
            $table->unsignedInteger('rewarded_id')->nullable();
            $table->integer('points');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->foreign('recognizer_id')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('cascade');
            $table->foreign('rewarded_id')
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
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
