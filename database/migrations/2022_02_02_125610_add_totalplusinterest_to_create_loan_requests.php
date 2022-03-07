<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalplusinterestToCreateLoanRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_loan_requests', function (Blueprint $table) {
            //
            $table->decimal('total_plus_interest', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('create_loan_requests', function (Blueprint $table) {
            //
            $table->dropColumn('total_plus_interest');
        });
    }
}
