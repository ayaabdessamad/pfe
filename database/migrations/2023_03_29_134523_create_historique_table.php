<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historique', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hotel');
            $table->unsignedBigInteger('id_service');
            $table->unsignedBigInteger('id_user');
            $table->date('date');
            $table->double('montant');


            $table->foreign('id_hotel')->references('id')->on('hotel');
            $table->foreign('id_service')->references('id_service')->on('services');
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('historique');
    }
}
