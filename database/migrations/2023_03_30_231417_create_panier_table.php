<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panier', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client')->unsigned();
            $table->foreignId('id_plat')->constrained('plats')->onDelete('cascade');
            $table->unsignedInteger('quantite');
            $table->double('prix');
            $table->foreign('id_client')

                ->references('id')

                ->on('users')

                ->onDelete('restrict')

                ->onUpdate('restrict');
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
        Schema::dropIfExists('panier');
    }
}
