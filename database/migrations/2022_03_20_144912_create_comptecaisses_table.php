<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptecaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptecaisses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('libele_operation');
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->dateTime('date_operation');
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
        Schema::dropIfExists('comptecaisses');
    }
}
