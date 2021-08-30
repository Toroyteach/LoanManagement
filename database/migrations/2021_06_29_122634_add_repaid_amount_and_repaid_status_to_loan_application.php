<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepaidAmountAndRepaidStatusToLoanApplication extends Migration
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
            $table->decimal('repaid_amount', 15, 2)->default(0)->after('loan_amount');
            $table->decimal('accumulated_amount', 15, 2)->default(0)->after('repaid_amount');
            $table->decimal('last_month_amount_paid', 15, 2)->default(0)->after('accumulated_amount');
            $table->date('date_last_amount_paid', 15, 2)->nullable()->after('last_month_amount_paid');
            $table->decimal('balance_amount', 15, 2)->default(0)->after('date_last_amount_paid');
            $table->boolean('repaid_status')->default(0)->after('balance_amount');
            $table->enum('loan_type', ['emergency', 'education', 'development', 'instantloan'])->after('repaid_status');
            $table->date('repayment_date')->nullable()->after('created_at');
            $table->date('defaulted_date')->nullable()->after('repayment_date');
            $table->integer('duration')->unsigned();
            $table->integer('duration_count')->default(1)->unsigned();
            $table->string('file')->nullable();
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
            $table->dropColumn('repaid_amount');
            $table->dropColumn('accumulated_amount');
            $table->dropColumn('last_month_amount_paid');
            $table->dropColumn('date_last_amount_paid');
            $table->dropColumn('balance_amount');
            $table->dropColumn('repaid_status');
            $table->dropColumn('loan_type');
            $table->dropColumn('repayment_date');
            $table->dropColumn('defaulted_date');
            $table->dropColumn('duration');
            $table->dropColumn('duration_count');
            $table->string('file')->nullable();
        });
    }
}
