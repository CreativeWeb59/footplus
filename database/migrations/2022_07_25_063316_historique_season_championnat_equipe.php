<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historique_equipes', function(Blueprint $table)
		{
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->foreign('season_id')
            ->references('id')
            ->on('seasons')
            ->onDelete('restrict')
            ->onUpdate('restrict');
            $table->unsignedBigInteger('championnat_id');
            $table->foreign('championnat_id')
            ->references('id')
            ->on('championnats')
            ->onDelete('restrict')
            ->onUpdate('restrict');
            $table->unsignedBigInteger('equipe_id');
            $table->foreign('equipe_id')
            ->references('id')
            ->on('equipes')
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
        Schema::dropIfExists('historique_equipes');
    }
};
