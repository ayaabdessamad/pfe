<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotificationIdTypeToUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropPrimary('notifications_pkey'); // supprimer la clé primaire existante
            $table->uuid('id')->change(); // changer le type de la colonne id en uuid
            $table->primary('id'); // ajouter une nouvelle clé primaire
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropPrimary('notifications_pkey'); // supprimer la clé primaire uuid
            $table->bigIncrements('id')->change(); // changer le type de la colonne id en bigIncrements
            $table->primary('id'); // ajouter une nouvelle clé primaire
        });
    }
}
