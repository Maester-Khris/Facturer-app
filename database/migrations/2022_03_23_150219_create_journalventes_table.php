<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalventesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalventes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('compteclient_id')->nullable()->unsigned();
            $table->integer('vente_id')->unsigned();
            $table->integer('montant');
            $table->dateTime('date_facturation');
            $table->timestamps();
            $table->foreign('compteclient_id')->references('id')->on('compteclients');
            $table->foreign('vente_id')->references('id')->on('ventes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalventes');
    }
}
