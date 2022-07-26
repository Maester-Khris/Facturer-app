<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_ticket');
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('comptoir_id')->unsigned();
            $table->integer('total');
            $table->string('statut')->default("en cours");
            $table->dateTime('date_operation'); 
            $table->timestamps();
            $table->foreign('comptoir_id')->references('id')->on('comptoirs');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
