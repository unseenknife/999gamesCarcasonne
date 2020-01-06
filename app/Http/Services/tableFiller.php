<?php
namespace App\Http\Services;
use Illuminate\Support\Collection;
class tableFiller 
{
    public function calculateTables($players)
    {
        //count all existing rounds
        $existingRounds = \App\Round::all()->count();
        //if rounds is below 4 we are still in round robin
        if($existingRounds < 4)
        {
            $round = new \App\Round();
            $round->save();
            $playerCount = $players->count();
            //start a new round and count how many players
            $this->calculateForPersons($playerCount, $players, $round->id);
            return redirect(route('home'))->with('success', 'Nieuwe ronde is gestart');
        }
        else
        {
            //round 5 and up
            //ladder competition
            $players = $players->values();
            $tablecount = ($players->count() / 2);
            //count how many tables are needed
            $round = new \App\Round();
            $round->save();
            //create a new round and call the ladder 
            $this->swissLadder($players, $tablecount, $round->id);
            return redirect(route('home'))->with('success', 'Nieuwe ronde in de ladder competitie is gestart');
        }
    }

    private function calculateForPersons($count, $players, $roundid)
    {
        $collection = collect(array_fill(0, $count, 1));
        // replaces the array content with 1, so we can count whether it can be devided by 4
        //then call the function depending on the amount of players left
        switch ($collection->count() % 4) {
            case 1:
                $onePlayerLeftOver = $this->calculateForOnePersonsLeftOver($players, $roundid);
                return "1 person left";
                break;
            case 2:
                $twoPlayerLeftOver = $this->calculateForTwoPersonsLeftOver($players, $roundid);
                return $twoPlayerLeftOver;
                break;
            default:
                $tables =  $players->chunk(4);
                return $this->generateTables($tables, $roundid);
        }
    }

    private function calculateForTwoPersonsLeftOver($players, $roundid)
    {
        
        $customTablesCount = $players->count() - 6;
        $normalUsers = $players->slice(0, $customTablesCount);
        $customTableUsers = $players->slice($customTablesCount);
        $tablesWith4Users = $normalUsers->chunk(4);
        $tablesWith3Users = $customTableUsers->chunk(3);
        //create arrays with 3 and 4 users to put on tables

        $this->generateTables($tablesWith4Users, $roundid);
        $this->generateTables($tablesWith3Users, $roundid);
  
    }

    private function calculateForOnePersonsLeftOver($players, $roundid)
    {
        
        $customTablesCount = $players->count() - 9;
        $normalUsers = $players->slice(0, $customTablesCount);
        $customTableUsers = $players->slice($customTablesCount);
        $tablesWith4Users = $normalUsers->chunk(4);
        $tablesWith3Users = $customTableUsers->chunk(3);
        //create arrays with 3 and 4 users to put on tables

        $this->generateTables($tablesWith4Users, $roundid);
        $this->generateTables($tablesWith3Users, $roundid);
  
    }

    private function generateTables($tables, $roundid)
    {

            $existingTables = \App\Table::where('round_id', $roundid)->get()->count();
            $existingTables++;
            //count how many tables already exit and +1 it to get the current table number

            foreach($tables as $table_player){
                $table = new \App\Table();
                $table->round_id = $roundid;
                $table->table = $existingTables;
                $table->save();
                $existingTables++;
                //create a new table, save it and increase table count by 1

                foreach($table_player as $person){
                    $player = new \App\Player();
                    $player->round_table_id = $table->id;
                    $player->player_id = $person['player_id'];
                    $player->save();
                    //insert a player into the current table
                }
            }
    }

    private function swissLadder($players, $tablecount, $roundid)
    {
        
        $negativeTableCount = 0 - $tablecount;
        $players2 = $players->take($negativeTableCount);
        $players = $players->take($tablecount);
        $players = $players->toArray();
        $players2 = $players2->values()->reverse()->toArray();
        //do some little flips and flaps on the collections so we get an array of the first half of players and the second half so we can match them toghether

        $variableUsedToCount = 0;
        $variableUsedToCountTables = 1;



        foreach($players as $player){
            $table = new \App\Table();
            $table->table = $variableUsedToCountTables;
            $table->round_id = $roundid;
            $table->save();
            //create a new table

            $player = new \App\Player();
            $player2 = new \App\Player();
            //create 2 new players

            $player->round_table_id = $table->id;
            $player2->round_table_id = $table->id;
            $player->player_id = $players[$variableUsedToCount]['player_id'];
            $player2->player_id = $players2[$variableUsedToCount]['player_id'];
            $player->save();
            $player2->save();
            //save the players to the table

            $variableUsedToCountTables++;
        }
        return "";
    }
}
