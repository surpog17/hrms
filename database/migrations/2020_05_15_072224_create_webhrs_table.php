<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('webhr_id')->nullable();
            $table->unsignedInteger('acc_id')->nullable();
            $table->foreign('acc_id')->references('acc_id')->on('employees')->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('webhrs');
    }
}
