<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('comptoir_id')->unsigned();
            $table->string('code_vente');
            $table->integer('montant_remise');
            $table->integer('montant_total');
            $table->integer('montant_net');
            $table->integer('indicatif');
            $table->date('date_operation');
            $table->boolean('statut')->default(false);
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('comptoir_id')->references('id')->on('comptoirs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventes');
    }
}
