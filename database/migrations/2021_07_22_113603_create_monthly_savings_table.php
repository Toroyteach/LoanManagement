<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlySavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_savings', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total_contributed', 15, 2);
            $table->decimal('monthly_amount', 15, 2);
            $table->decimal('overpayment_amount', 15, 2);
            $table->string('created_by');
            $table->date('next_payment_date');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_savings');
    }
}
