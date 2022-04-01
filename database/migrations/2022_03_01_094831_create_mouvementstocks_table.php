<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouvementstocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouvementstocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marchandise_id')->unsigned();
            $table->integer('stockdepot_id')->unsigned();
            $table->string('reference_mouvement');
            $table->string('type_mouvement');
            $table->string('destination')->nullable();
            $table->integer('quantite_mouvement');
            $table->dateTime('date_operation');
            $table->timestamps();
            $table->foreign('marchandise_id')->references('id')->on('marchandises');
            $table->foreign('stockdepot_id')->references('id')->on('stockdepots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mouvementstocks');
    }
}
