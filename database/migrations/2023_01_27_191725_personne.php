<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personne', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('prénom');
            $table->string('email');
            $table->string('password');
            $table->string('role');
            $table->string('statut');
            $table->integer('solde');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personne');
    }
}
