<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('privileged_link_id')->unsigned();
            $table->foreign('privileged_link_id')->references('id')->on('acc_privileged_links');
            $table->string('title', 100);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('acc_roles');
    }
}
