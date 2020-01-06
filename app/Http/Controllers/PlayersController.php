<?php

namespace App\Http\Controllers;

use App\Player;
use App\User;
use App\Round;
use App\Table;
use App\Http\Services\PointCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Jennifer
    //logout user after register with message
    public function logOutRegister(){
        Auth::logout();

        return redirect(route('home'))->with('success','Om een player te zijn verifiëer je mail' );
    }

    //Jennifer
    //logout user after email verification with message
    public function logOutVerify(){

        //Jennifer, Nick en Lex

        return redirect(route('home'))->with('success','Email met succes geverifieerd. Je bent nu een player' );
    }


    public function index()
    {
        //count how many rounds there are
        $round = Round::all()
            ->count();

        $data = [
                'users' => User::where('roleid',2)->get()
            ];

        //if there is a round then do below
        if($round >= 1) {
            //return $data;
            return view('players.index')->with($data);
        }
        //else redirect to home
        else{
            return redirect(route('home'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show($player_id)
    {
        //get user
        $user = User::where('id', $player_id)
            ->get();

        //count how many rounds there are
        $round = Round::all()
            ->count();

        //if user role id is player and there is a round then do below
        if($user[0]->roleid == 2 && $round >= 1) { 

            //Jennifer en Nick
            //get all round_tables
            $round_table_ids = Table::all();

            //count how many rounds there are
            $chunkRounds = Round::all()->count();

            //set variable i
            $i=0;
            //foreach table calculate the score and weight
            foreach($round_table_ids as $round_table_id){
                $rounds[$i] = PointCalculator::ScoreCalculator($round_table_id);
                $i++;
            }

            //set variable rounds in a collection
            $collection = collect($rounds);
            //flatten the collection and sortby player_id and chunk from data the player
            $datas = $collection->flatten(1)->sortByDesc('player_id')->chunk($chunkRounds);

            //set variable j
            $j=0;

            //set an empty variable in a array
            $total[] = [];
            //foreach datas the score + weight from player from each round
            foreach($datas as $data){

                //set variabe score[$j] and weight[$j] to 0
                $score[$j]=0;
                $weight[$j]=0;
                //foreach data(the score + weight from player one round)
                foreach ($data as $player){

                    //set variable score and each time it loops do score + player['score']
                    $score[$j] = $score[$j] + $player['score'];
                    //set variable score and each time it loops do weight + player['weight']
                    $weight[$j] = $weight[$j] + $player['weight'];
                    //in variable total set the total score, weight and from which player
                    $total[$j]['player_id'] = $player['player_id'];
                    $total[$j]['score'] = $score[$j];
                    $total[$j]['weight'] = $weight[$j];
                }

                //variable j++
                $j++;
            }

            //make from total a new collection
            $collection2 = collect($total);
            //sort collection by weight and score
            //this makes it so that it sorts by score the highest and then weight the highest
            $newtotalranks = $collection2->sortByDesc('weight')->sortByDesc('score');


            //set an empty variable in a array
            $playerRank[] =[];
            //set variable r to 0
            $r = 0;
            //foreach newtotalranks so you get each player from each table the player was in
            foreach($newtotalranks as $newtotalrank){

                //from the player_id get f_name and l_name
                $player = User::select('f_name', 'l_name')
                    ->where('id', $newtotalrank['player_id'])
                    ->get();

                //if the player_id from newtotalRank is the same as the player_id then do below
                if($newtotalrank['player_id'] == $player_id) {
                    $playerRank['score'] = $newtotalrank['score'];
                    $playerRank['player'] = $player[0]->f_name . ' ' . $player[0]->l_name;
                    $playerRank['rank'] = $r + 1;
                }
                //variable r ++
                $r++;
            }

            //Jennifer
            //select from the table round_player where player_id = $player_id
            //join round_table and users table
            //select and get collums

            $profiles = Player::where('player_id', $player_id)
                ->join('round_table', 'round_player.round_table_id', 'round_table.id')
                ->join('users', 'users.id', 'round_player.player_id')
                ->select('round_player.round_table_id', 'round_table.round_id', 'round_table.table','users.f_name', 'users.l_name', 'round_player.points')
                ->get();

            //sum the points from the player
            $totalPoints = Player::where('player_id', $player_id)
                ->sum('points');


            //set an empty variable in a array and define $i
            $placeRounds [] = [];
            $h= 1;

            //foreach profiles as profile
            //we to this to get the round_table_id for every game the player has played
            foreach ($profiles as $profile){

                // for every game the player played select/get the whole table
                $roundTables[$h] = Table::where('round_table.id', $profile->round_table_id)
                    ->join('round_player', 'round_table.id', 'round_player.round_table_id')
                    ->orderBy('round_player.points', 'desc')
                    ->select( 'round_table.id','round_table.round_id', 'round_table.table', 'round_player.player_id', 'round_player.points')
                    ->get();


    //            return $roundTables;
                //set variable $r and $x
                $r= 0;
                $x= 0;
                $k=0;
                //foreach roundTables as roundTable
                //now we get every table (the 4 players on the tables etc)
                foreach($roundTables as $roundTable){

                    //set variable round_table_id, in it set the id from the round table which the player has played
                    $round_table_id = Table::select('id')
                        ->where('id', $roundTable[0]['id'])
                        ->get();

                    //for the table calculate the score and weight
                    $playersScore[$k] = PointCalculator::ScoreCalculator($round_table_id[0]);
                    //set this in a collection
                    $collection3 = collect($playersScore);
                    //sort collection by weight and score
                    //this makes it so that it sorts by score the highest and then weight the highest
                    $playerScore = $collection3->flatten(1)->sortByDesc('weight')->sortByDesc('score');

                    //make an array
                    $playerResultRound[] = [];
                    //foreach player in the table with score and weight
                    foreach($playerScore as $score) {

                        //from the player_id get f_name and l_name
                        $playerName = User::select('f_name', 'l_name')
                            ->where('id', $score['player_id'])
                            ->get();

                        //if the score['player_id'] is the same as player_id then do below
                        if($score['player_id'] == $player_id) {

                            //set variable playerResultRound['score'] with score
                            $playerResultRound['score'] = $score['score'];
                            //set variable playerResultRound['player'] with player name
                            $playerResultRound['player'] = $playerName[0]->f_name . ' ' . $playerName[0]->l_name;
                        }
                    }

                    //count $roundTable and set it in variable $countPlayer
                    //roundTable is filled with the players in the table so every time it foreached you get a player in the table
                    $countPlayers = count($roundTable);

                    //foreach table the player, score and mmr
                    foreach($roundTable as $roundTab) {

                        //set rank['rank] this is your rank or place, the players are ordered by points
                        //so the one with the most points get place 1 etc etc and give it with playerid
                        $rank[$r]['rank']=$x + 1;
                        $rank[$r]['player']=$roundTab->player_id;

                        // if the player_id is the player then fill the variable $profileRank
                        if($roundTab->player_id == $player_id){

                            $profileRank[$r]['rank']=$x + 1;
                            $profileRank[$r]['round']=$roundTab->round_id;
                            $profileRank[$r]['table']=$roundTab->table;
                            $profileRank[$r]['player']=$roundTab->player_id;
                            $profileRank[$r]['points']=$roundTab->points;
                            $profileRank[$r]['score']= $playerResultRound['score'];
                        }
                        //every loop set $r and $x +1
                        $r++;
                        $x++;

                        // if $x > then the players on the table set variable x on 0
                        if ($x > $countPlayers - 1){
                            $x = 0;
                        }
                    }
                    //every loop set $k + 1
                    $k++;
                }
                //every loop set $i + 1
                $h++;
            }

            //set variable data with below variables
            $data= [
                'playerId' => $player_id,
                'profiles' => $profiles,
                'totalPoints' => $totalPoints,
                'placeRounds' => $placeRounds,
                'profileRank' => $profileRank,
                'playerRank' => $playerRank,
                ];
        
             //return view with variable data
             return view('players.show')->with($data);
        }
        //else redirect to home
        else{
            return redirect(route('home'))->with('error', 'Speler bestaat niet');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
