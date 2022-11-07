<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalachatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalachats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_compte');
            // $table->integer('comptefournisseur_id')->unsigned();
            $table->integer('facture_id')->unsigned();
            $table->dateTime('date_facturation');
            $table->integer('montant');
            $table->timestamps();
            // $table->foreign('comptefournisseur_id')->references('id')->on('comptefournisseurs');
            $table->foreign('facture_id')->references('id')->on('factures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalachats');
    }
}
