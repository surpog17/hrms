<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('acc_id')->unique();
            $table->string('full_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->boolean('is_manager')->nullable();
            $table->boolean('is_driver')->nullable();
            $table->boolean('is_active')->nullable();
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->boolean('probation')->nullable();
            $table->unsignedBigInteger('raw_id')->nullable();
            $table->foreign('raw_id')->references('id')->on('raws');
            $table->unsignedBigInteger('calculated_id')->nullable();
            $table->foreign('calculated_id')->references('id')->on('calculateds')->onDelete('cascade');
            $table->unsignedBigInteger('absent_id')->nullable();
            $table->foreign('absent_id')->references('id')->on('absents')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
}
