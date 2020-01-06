<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_score', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('score');
            $table->timestamps();
        });

        DB::table('base_score')->insert(
            array(
                'score' => 5
            )
        );

        DB::table('base_score')->insert(
            array(
                'score' => 3
            )
        );

        DB::table('base_score')->insert(
            array(
                'score' => 2
            )
        );

        DB::table('base_score')->insert(
            array(
                'score' => 1
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_score');
    }
}
