<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateGuarantorLoanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_guarantor_loan_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('request_status', ['Pending', 'Rejected', 'Accepted'])->default('Pending');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('create_loan_requests')->onDelete('cascade');
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
        Schema::dropIfExists('create_guarantor_loan_requests');
    }
}
