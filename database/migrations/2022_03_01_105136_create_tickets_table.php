<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vente_id')->unsigned();
            $table->integer('marchandise_id')->unsigned();
            $table->integer('quantite');
            $table->string('type_vente');
            $table->integer('prix_vente');
            $table->timestamps();
            $table->foreign('vente_id')->references('id')->on('ventes');
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
        Schema::dropIfExists('tickets');
    }
}
