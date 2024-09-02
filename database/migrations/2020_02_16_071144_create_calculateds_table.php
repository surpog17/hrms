<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculateds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('acc_id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('total_late')->nullable();
            $table->unsignedBigInteger('total_overtime')->nullable();
            $table->unsignedBigInteger('morning_ovetime')->nullable();
            $table->unsignedBigInteger('morning_late')->nullable();
            $table->unsignedBigInteger('afternoon_overtime')->nullable();
            $table->unsignedBigInteger('afternoon_early')->nullable();
            $table->unsignedBigInteger('weekend_overtime')->nullable();
            $table->unsignedBigInteger('lunch_late')->nullable();
            $table->boolean('active');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
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
        Schema::dropIfExists('calculateds');
    }
}
