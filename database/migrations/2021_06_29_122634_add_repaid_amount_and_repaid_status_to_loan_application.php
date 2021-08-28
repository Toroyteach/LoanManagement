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
            $table->boolean('repaid_status')->default(0)->after('loan_amount');
            $table->decimal('repaid_amount', 15, 2)->default(0)->after('loan_amount');
            $table->enum('loan_type', ['emergency', 'education', 'development', 'instantloan'])->after('loan_amount');
            $table->date('repayment_date')->nullable()->after('created_at');
            $table->integer('duration')->unsigned();
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
            $table->dropColumn('repaid_status');
            $table->dropColumn('loan_type');
            $table->dropColumn('repayment_date');
            $table->dropColumn('duration');
            $table->string('file')->nullable();
        });
    }
}
