<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->decimal('total_award', 10, 2)->default(0.0)->nullable();
            $table->decimal('tax', 10, 2)->default(0.0)->nullable();
            $table->decimal('taxable_income', 10, 2)->default(0.0)->nullable();
            $table->decimal('emp_pension', 10, 2)->default(0.0)->nullable();
            $table->decimal('comp_pension', 10, 2)->default(0.0)->nullable();
            $table->decimal('tax_tran_allowance', 10, 2)->default(0.0)->nullable();
            $table->decimal('trans_allowance', 10, 2)->default(0.0)->nullable();
            $table->decimal('total_deduction', 10, 2)->default(0.0)->nullable();
            $table->decimal('gross_salary', 10, 2)->default(0.0)->nullable();
            $table->decimal('gross_income', 10, 2)->default(0.0)->nullable();
            $table->decimal('net_income', 10, 2)->default(0.0)->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
