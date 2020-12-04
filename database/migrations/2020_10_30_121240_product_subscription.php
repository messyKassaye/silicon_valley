<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('products_subscribtion');
        Schema::create('products_subscribtion', function (Blueprint $table) {
            $table->integer('products_id')->unsigned()->index();
            $table->integer('subscribtion_id')->unsigned()->index();
            $table->primary(['products_id', 'subscribtion_id']);
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
