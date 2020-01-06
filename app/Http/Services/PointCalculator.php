<?php
/**
 * Created by PhpStorm.
 * User: nickm
 * Date: 19-12-2018
 * Time: 09:47
 */

namespace App\Http\Services;

use App\Player;
use App\Score;


class PointCalculator
{

    public static function ScoreCalculator($round_table_id){

        //Gets points and player_id from the round_player table descending on points for a certain table in a certain round
        //by using the Player model --Nick
        $points = Player::select('points', 'player_id')
            ->orderBy('points', 'desc')
            ->where('round_table_id', $round_table_id->id)
            ->get();

        //Gets total points from the round_player table for a certain table in a certain round
        //by using the Player model --Nick
        $totalpoints = Player::select('points')
            ->where('round_table_id', $round_table_id->id)
            ->sum('points');

        //Gets score from the base_score table
        //by using the Score model --Nick
        $base_score = Score::select('score')
            ->get();

        //Checks if there are 4 or 3 players at a table and makes an array out of the 4 or 3 values --Nick
        if($points->count() == 4){
            $array = array($points[0]->points, $points[1]->points, $points[2]->points, $points[3]->points);
         }
         if($points->count() == 3){
            $array = array($points[0]->points, $points[1]->points, $points[2]->points);
         }
         if($points->count() == 2){
            $array = array($points[0]->points, $points[1]->points);
         }

         //Counts how many values are equal within the array --Nick
        $cnt = array_count_values($array);

         //foreached every player --Nick
        $i = 0;
        foreach($points as $point) {


            //Checks if all players at 1 table have 0 points and if so it gives every player a score of 0 --Nick
            if($cnt[$points[$i]->points] == 4 && $points[$i]->points == 0 || $cnt[$points[$i]->points] == 3 && $points[$i]->points == 0 || $cnt[$points[$i]->points] == 2 && $points[$i]->points == 0 ){
                $shared = 0;
            } else {

                //Calculates the average points of 2 scores when a players shares the same points if the count is greater than 1
                //else it will give the normal score --Nick
                if ($cnt[$points[$i]->points] > 1) {
                    $shared = 0;
                    for ($x = 0; $x < $cnt[$points[$i]->points]; $x++) {
                        $shared = $shared + $base_score[$x]->score;
                    }
                    $shared = $shared / $cnt[$points[$i]->points];

                } else {
                    $shared = $base_score[$i]->score;
                }

            }

            //Fills the player_id and score into result --Nick
            $result[$i]['player_id'] = $point->player_id;
            $result[$i]['score'] = $shared;


            //Checks if the total points is 0, if its 0 it'll fill the result with a weight of 0 else it will calculate the weight
            //and fills result with that weight --Nick
            if($totalpoints == 0){
                $result[$i]['weight'] = 0;

            } else {
                $result[$i]['weight'] = $point->points / $totalpoints * 100;

            }

            $i++;
        }

        return $result;

    }
}

