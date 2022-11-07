<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptefournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptefournisseurs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fournisseur_id')->unsigned();
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->dateTime('date_credit')->nullable();
            $table->dateTime('date_debit')->nullable();
            $table->timestamps();
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comptefournisseurs');
    }
}
