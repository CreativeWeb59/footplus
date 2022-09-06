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
        Schema::create('adjusts', function (Blueprint $table) {
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

            $table->unsignedBigInteger('equipe_id')->default(1);
            $table->foreign('equipe_id')
            ->references('id')
            ->on('equipes')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->integer('valeur')->default(1);
            $table->text('commentaire')->nullable();

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
        Schema::dropIfExists('adjusts');
    }
};
