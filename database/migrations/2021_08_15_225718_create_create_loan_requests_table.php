<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateLoanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_loan_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('loan_amount', 15, 2);
            $table->longText('description')->nullable();
            $table->enum('loan_type', ['Emergency', 'SchoolFees', 'Development', 'InstantLoan']);
            $table->integer('duration')->unsigned();
            $table->string('file')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('create_loan_requests');
    }
}
