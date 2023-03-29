<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id_service');
            $table->string('nom');
            $table->string('description');
            $table->string('image');
            $table->string('type');
            $table->integer('id_hotel')->unsigned();
            $table->foreign('id_hotel')

                ->references('id')

                ->on('hotel')

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
        Schema::dropIfExists('services');
    }
}
