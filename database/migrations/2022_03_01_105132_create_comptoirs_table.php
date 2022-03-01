<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptoirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptoirs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->unsigned();
            $table->integer('personnel_id')->unsigned();
            $table->integer('caisse_id')->unsigned();
            $table->string('libelle');
            $table->integer('comptabiliser');
            $table->timestamps();
            $table->foreign('depot_id')->references('id')->on('depots');
            $table->foreign('personnel_id')->references('id')->on('personnels');
            $table->foreign('caisse_id')->references('id')->on('caisses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comptoirs');
    }
}
