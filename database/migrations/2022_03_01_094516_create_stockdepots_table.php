<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockdepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockdepots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->unsigned();
            $table->integer('marchandise_id')->unsigned();
            $table->integer('quantite_stock');
            $table->string('qte_derniere_modif');
            $table->date('date_derniere_modif_qté')->nullable();
            $table->timestamps();
            $table->foreign('marchandise_id')->references('id')->on('marchandises');
            $table->foreign('depot_id')->references('id')->on('depots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockdepots');
    }
}
