<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmiToLoanApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            //
            $table->decimal('equated_monthly_instal', 15, 2)->default(0)->after('balance_amount');
            $table->decimal('next_months_pay', 15, 2)->default(0)->after('last_month_amount_paid');
            $table->date('next_months_pay_date')->nullable()->after('next_months_pay');
        });

        Schema::table('create_loan_requests', function (Blueprint $table) {
            //
            $table->decimal('emi', 15, 2)->default(0)->after('loan_amount');
        });

        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->string('value')->after('user_id');
        });

        Schema::table('loan_applications', function (Blueprint $table) {
            $table->decimal('loan_amount_plus_interest', 15, 2)->after('loan_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            //
            $table->dropColumn('equated_monthly_instal');
            $table->dropColumn('next_months_pay');
            $table->dropColumn('next_months_pay_date');
        });

        Schema::table('create_loan_requests', function (Blueprint $table) {
            //
            $table->dropColumn('emi');
        });

        Schema::table('loan_guarantors', function (Blueprint $table) {
            //
            $table->dropColumn('value');
        });

        Schema::table('loan_applications', function (Blueprint $table) {
            //
            $table->dropColumn('loan_amount_plus_interest');
        });
    }
}
