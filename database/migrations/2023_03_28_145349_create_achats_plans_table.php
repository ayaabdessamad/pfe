<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchatsPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achats_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('montant_paye');

            $table->integer('id_client')->unsigned();
            $table->integer('id_plan')->unsigned();
            $table->foreign('id_client')

                ->references('id')

                ->on('users')

                ->onDelete('restrict')

                ->onUpdate('restrict');
            $table->foreign('id_plan')

                ->references('id')

                ->on('plans')

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
        Schema::dropIfExists('achats_plans');
    }
}
