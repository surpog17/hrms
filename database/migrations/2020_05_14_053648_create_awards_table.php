<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->decimal('bonus', 10, 2)->default(0.0)->nullable();
            $table->decimal('allowance', 10, 2)->default(0.0)->nullable();
            $table->decimal('ieb', 10, 2)->default(0.0)->nullable();
            $table->decimal('eodb', 10, 2)->default(0.0)->nullable();
            $table->decimal('cdb', 10, 2)->default(0.0)->nullable();
            $table->decimal('mpeqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('speqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('tvcqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('bepeqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('fhaqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('tpcqb', 10, 2)->default(0.0)->nullable();
            $table->decimal('exam_bonus', 10, 2)->default(0.0)->nullable();
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
        Schema::dropIfExists('awards');
    }
}
