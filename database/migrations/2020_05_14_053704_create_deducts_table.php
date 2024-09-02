<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('employee_name', 100)->nullable();
            $table->decimal('medical', 10, 2)->default(0.0)->nullable();
            $table->decimal('absent', 10, 2)->default(0.0)->nullable();
            $table->decimal('other', 10, 2)->default(0.0)->nullable();
            $table->decimal('loan', 10, 2)->default(0.0)->nullable();
            $table->decimal('pma', 10, 2)->default(0.0)->nullable();
            $table->decimal('car', 10, 2)->default(0.0)->nullable();
            $table->decimal('exam', 10, 2)->default(0.0)->nullable();
            $table->decimal('latecommer', 10, 2)->default(0.0)->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('deducts');
    }
}
