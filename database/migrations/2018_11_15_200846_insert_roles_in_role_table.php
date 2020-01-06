<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertRolesInRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Made by Lex
     * Insert all pre-defined roles
     *
     */
    public function up()
    {
        DB::table('roles')->insert(
            array(
                'name' => "User"
            )
         );

         DB::table('roles')->insert(
            array(
                'name' => "Player"
            )
         );

         DB::table('roles')->insert(
            array(
                'name' => "Staff"
            )
         );

        DB::table('roles')->insert(
            array(
                'name' => "Admin"
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
         DB::table('roles')->truncate(
         );
    }
}
