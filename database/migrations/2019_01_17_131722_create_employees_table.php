<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100);
            $table->unique('username');
            $table->dateTime('last_login')->nullable;
            $table->integer('login_attempts')->default(0);
            $table->dateTime('last_attempt')->nullable;
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('acc_employees');
    }
}
