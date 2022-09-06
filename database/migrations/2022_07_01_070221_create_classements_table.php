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
        Schema::create('classements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seasons_id')->default(1);
            $table->foreign('seasons_id')
            ->references('id')
            ->on('seasons')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('equipes_id')->default(1);
            $table->foreign('equipes_id')
            ->references('id')
            ->on('equipes')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('championnats_id')->default(1);
            $table->foreign('championnats_id')
            ->references('id')
            ->on('championnats')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->integer('classement_en_cours')->default(1);
            $table->integer('points')->default(0);
            $table->integer('nb_match_joue')->default(0);
            $table->integer('nb_match_gagne')->default(0);
            $table->integer('nb_match_null')->default(0);
            $table->integer('nb_match_perdu')->default(0);
            $table->integer('but_marque')->default(0);
            $table->integer('but_encaisse')->default(0);
            $table->integer('difference_but')->default(0);
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
        Schema::dropIfExists('classements');
    }
};
