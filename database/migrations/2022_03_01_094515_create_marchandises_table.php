<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference', 25);
            $table->string('designation', 100);
            $table->integer('prix_achat');
            $table->integer('dernier_prix_achat');
            $table->integer('prix_vente_detail');
            $table->integer('prix_vente_gros');
            $table->string('unite_achat', 25);
            $table->double('cmup');
            $table->string('conditionement', 100);
            $table->integer('quantité_conditionement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marchandises');
    }
}
