<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GenderUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('gender_user');
        Schema::create('gender_user', function (Blueprint $table) {
            $table->integer('gender_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->primary(['gender_id', 'user_id']);
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
