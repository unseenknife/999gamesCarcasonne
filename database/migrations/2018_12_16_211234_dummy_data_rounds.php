<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DummyDataRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            array(
                'f_name' => "Calvin",
                'l_name' => "Musch",
                'email' => "calvin@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
            )
         );

         DB::table('users')->insert(
            array(
                'f_name' => "Pepijn",
                'l_name' => "Wolf",
                'email' => "Pepijn@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
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
        DB::table('users')->truncate();
        DB::table('rounds')->truncate();
        DB::table('round_table')->truncate();
        DB::table('round_player')->truncate();
    }
}
