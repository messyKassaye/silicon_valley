<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PassionUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('passion_user');
        Schema::create('passion_user', function (Blueprint $table) {
            $table->integer('passion_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->primary(['passion_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
