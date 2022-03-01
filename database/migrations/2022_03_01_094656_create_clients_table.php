<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->unsigned();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->integer('solde');
            $table->string('derniere_modif_solde');
            $table->date('date_derniere_modif_solde');
            $table->string('numero_client');
            $table->string('type_client');
            $table->string('type_paiement');
            $table->boolean('multi_depot_caisses');
            $table->timestamps();
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
        Schema::dropIfExists('clients');
    }
}