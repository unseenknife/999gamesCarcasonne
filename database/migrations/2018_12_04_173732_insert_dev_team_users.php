<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDevTeamUsers extends Migration
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
                'f_name' => "Lex",
                'l_name' => "Meijer",
                'email' => "s1133750@student.windesheim.nl",
                'roleid' => 4,
                'password' => "\$2y\$10\$GvZ8XQ8v9VkDFl3XxoCTCuIBjgffNtYxjNekQQ1VWG5EvhqjxC0Yy",
                'phone_nr' => "06302Kaassoufle"
            )
         );

         DB::table('users')->insert(
            array(
                'f_name' => "Jennifer",
                'l_name' => "Lee",
                'roleid' => 4,
                'email' => "s1133868@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
            )
         );

         DB::table('users')->insert(
            array(
                'f_name' => "Nick",
                'l_name' => "Mensink",
                'roleid' => 4,
                'email' => "s1047594@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
            )
         );

         DB::table('users')->insert(
            array(
                'f_name' => "Remko",
                'l_name' => "Huisman",
                'roleid' => 4,
                'email' => "s1125975@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
            )
         );
         
         DB::table('users')->insert(
            array(
                'f_name' => "Kimberley",
                'l_name' => "van den Bos",
                'roleid' => 4,
                'email' => "s1131714@student.windesheim.nl",
                'password' => "\$2y\$10\$3EPJ5D/Ug2mlDIB4R3Vx8.OeiV928M70JMeN9N6v2eYoFwoqFrfBC",
                'phone_nr' => "06302Kaassoufle"
            )
         );

         DB::table('users')->insert(
            array(
                'f_name' => "Samantha",
                'l_name' => "Vermeulen",
                'roleid' => 4,
                'email' => "s1123902@student.windesheim.nl",
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
    }
}
