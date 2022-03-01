<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->unsigned();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe');
            $table->string('telephone');
            $table->string('email');
            $table->string('cni');
            $table->date('date_embauche');
            $table->string('type_contrat');
            $table->string('poste');
            $table->string('statut');
            $table->string('matricule');
            $table->string('matricule_cnps');
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
        Schema::dropIfExists('personnels');
    }
}
