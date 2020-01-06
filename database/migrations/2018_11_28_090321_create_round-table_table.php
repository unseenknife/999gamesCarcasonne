<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundTableTable extends Migration
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
        Schema::create('round_table', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('round_id');
            $table->foreign('round_id')
                ->references('id')->on('rounds')
                ->onDelete('cascade');
            $table->integer('table');
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
