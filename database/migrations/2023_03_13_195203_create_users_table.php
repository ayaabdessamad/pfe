<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('photo');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('statut');
            $table->integer('solde');

            $table->integer('id_hotel')->unsigned();
            $table->integer('id_service')->unsigned();
            $table->foreign('id_hotel')

                ->references('id')

                ->on('hotel')

                ->onDelete('restrict')

                ->onUpdate('restrict');
            $table->foreign('id_service')

                ->references('id_service')

                ->on('services')

                ->onDelete('restrict')

                ->onUpdate('restrict');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
