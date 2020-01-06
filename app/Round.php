<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public static function isRoundPlayed()
    {
        $round = Round::all()
            ->count();

        if($round >= 1) {
            return true;
        }
        else{
            return false;
        }
    }
}
