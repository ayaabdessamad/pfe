<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite');
            $table->integer('prix');
            $table->timestamps();
            $table->integer('id_client')->unsigned();
            $table->integer('id_plat')->unsigned();
            $table->foreign('id_client')

                ->references('id')

                ->on('users')

                ->onDelete('restrict')

                ->onUpdate('restrict');
            $table->foreign('id_plat')

                ->references('id')

                ->on('plats')

                ->onDelete('restrict')

                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande');
    }
}
