<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailcomptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailcomptes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_compte');
            $table->string('reference_operation');
            $table->dateTime('date_operation');
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->integer('solde')->default(0);
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
        Schema::dropIfExists('detailcomptes');
    }
}
