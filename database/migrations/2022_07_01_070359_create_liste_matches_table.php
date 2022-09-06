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
        Schema::create('liste_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seasons_id')->default(1);
            $table->foreign('seasons_id')
            ->references('id')
            ->on('seasons')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('championnats_id')->default(1);
            $table->foreign('championnats_id')
            ->references('id')
            ->on('championnats')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('equipes1_id')->default(1);
            $table->foreign('equipes1_id')
            ->references('id')
            ->on('equipes')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('equipes2_id')->default(2);
            $table->foreign('equipes2_id')
            ->references('id')
            ->on('equipes')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->integer('num_journee')->default(1);
            $table->string('score')->nullable();
            $table->text('commentaire')->nullable();
            $table->date('date_match')->nullable();
            $table->string('heure_match','15')->nullable();
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
        Schema::dropIfExists('liste_matches');
    }
};
