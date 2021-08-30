<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_step_auth_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userId')->unsigned()->index();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('authCode')->nullable();
            $table->integer('authCount');
            $table->boolean('authStatus')->default(false);
            $table->dateTime('authDate')->nullable();
            $table->dateTime('requestDate')->nullable();
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
        Schema::dropIfExists('multi_step_auth_tables');
    }
}
