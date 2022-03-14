<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stockdepot_id')->unsigned();
            $table->integer('marchandise_id')->unsigned();
            $table->integer('ancienne_quantite');
            $table->integer('quantite_reajuste');
            $table->integer('difference');
            $table->date('date_reajustement');
            $table->timestamps();
            $table->foreign('stockdepot_id')->references('id')->on('stockdepots');
            $table->foreign('marchandise_id')->references('id')->on('marchandises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventaires');
    }
}
