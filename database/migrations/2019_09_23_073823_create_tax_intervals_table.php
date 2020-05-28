<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_intervals', function (Blueprint $table) {
	        $table->increments('id');
            $table->unsignedInteger('tax_id');
            $table->double('start');
            $table->double('end');
            $table->double('rate');
            $table->timestamps();

            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
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
        Schema::dropIfExists('tax_intervals');
    }
}
