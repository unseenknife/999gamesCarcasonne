<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Made by Jennifer
     *
     */
    public function up()
    {
        Schema::create('round_player', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('round_table_id');
        $table->foreign('round_table_id')
              ->references('id')->on('round_table')
              ->onDelete('cascade');
        $table->unsignedInteger('player_id');
        $table->foreign('player_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        $table->integer('points')
            ->default(0);
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
        //
    }
}
