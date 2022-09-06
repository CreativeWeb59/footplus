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
        Schema::create('championnats', function (Blueprint $table) {
            $table->id();

            $table->string('nom')->unique();
            $table->string('logo');
            $table->integer('nb_equipes')->default(20);
            $table->unsignedBigInteger('countries_id')->default(1);
            $table->foreign('countries_id')
            ->references('id')
            ->on('countries')
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
        Schema::dropIfExists('championnats');
    }
};
