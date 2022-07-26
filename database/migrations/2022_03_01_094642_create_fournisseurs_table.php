<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->nullable()->unsigned();
            $table->string('nom_complet');
            $table->string('telephone');
            $table->integer('solde')->default(0);
            $table->dateTime('date_dernier_calcul_solde')->nullable();
            // $table->string('numero_fournisseur');
            $table->string('type_fournisseur');
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
        Schema::dropIfExists('fournisseurs');
    }
}
