<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mornings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('calculated_id')->nullable();
            $table->foreign('calculated_id')->references('id')->on('calculateds')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->unsignedBigInteger('late')->nullable();
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mornings');
    }
}
