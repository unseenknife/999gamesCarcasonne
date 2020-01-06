<?php

namespace App\Http\Controllers;

use App\Table;
use App\Round;
use App\User;

use App\Http\Services\PointCalculator;

use Illuminate\Http\Request;


class RankingListsRoundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function loadTimer(){
        return view('administration.timer');
    }
    public function index()
    {
         //count how many rounds there are
        $round = Round::all()
            ->count();

        //if there is a round then do below
        if($round >= 1) {

            //Gets everything from table --Nick & Jennifer
            $round_table_ids = Table::all();

            //Gets and counts all the rounds --Nick & Jennifer
            $chunkRounds = Round::all()->count();

            //Uses PointsCalculator to calculate scores and weight for every table in a certain round --Nick & Jennifer
            $i=0;
            foreach($round_table_ids as $round_table_id){
                $rounds[$i] = PointCalculator::ScoreCalculator($round_table_id);
                $i++;
            }

            //Makes a collection from the rounds sorts by player_id and chunks it per round --Nick & Jennifer
            $collection = collect($rounds);
            $datas = $collection->flatten(1)->sortByDesc('player_id')->chunk($chunkRounds);

                //Adding up all score, weight and also adding player id to the total --Nick & Jennifer
                $j=0;
                $total[] = [];
                foreach($datas as $data){

                    $score[$j]=0;
                    $weight[$j]=0;
                    foreach ($data as $player){

                        $score[$j] = $score[$j] + $player['score'];
                        $weight[$j] = $weight[$j] + $player['weight'];
                        $total[$j]['player_id'] = $player['player_id'];
                        $total[$j]['score'] = $score[$j];
                        $total[$j]['weight'] = $weight[$j];

                    }

                $j++;


                //Makes a collection from the total sorts by weight and score --Nick & Jennifer
                $collection2 = collect($total);
                $newtotalranks = $collection2->sortByDesc('weight')->sortByDesc('score');

                }

            //Loads the data that gets used on the view into an array --Nick & Jennifer
            $ranking[] =[];
            $r = 0;
            foreach($newtotalranks as $newtotalrank){

                $player = User::select('f_name', 'l_name')
                    ->where('id', $newtotalrank['player_id'])
                    ->get();

                $ranking[$r]['score'] = $newtotalrank['score'];
                $ranking[$r]['player'] = $player[0]->f_name . ' ' . $player[0]->l_name;
                $ranking[$r]['rank'] = $r + 1;
                $r++;
            }

            //Counts the distinct rounds played --Nick & Jennifer
            $roundCounter = Table::select('round_id')
                ->distinct('round_id')
                ->get();

            //Fills an array with the round numbers --Nick & Jennifer
            $i = 0;
            $counterRounds [] = "";
            foreach($roundCounter as $roundCount){


                $counterRounds[$i]  = $roundCount->round_id;
                $i++;
            }

            //Fills $data with both of the array's --Nick & Jennifer
            $data = [
                'counterRounds' => $counterRounds,
                'ranking' => $ranking
            ];
                //Returns $data towards the view --Nick & Jennifer
                return view('ranklist.index')->with($data);
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
        // Samantha
        // for the timer
        if(isset($request->type) && $request->type="timer"){
        $min = $request->mns * 60;
        $sec = $request->scs + $min;
            $now = time();
            $timestamp_file = 'end_timestamp.txt';


            if(!file_exists($timestamp_file))
            {
                file_put_contents($timestamp_file, time()+$sec);
            }
            $end_timestamp = file_get_contents($timestamp_file);
//    $difference = $end_timestamp - $current_timestamp;

            if ($now >= $end_timestamp) {
                file_put_contents($timestamp_file, time()+$sec);

            }
            return redirect('/ranglijst');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($round_id)
    {

        //count how many rounds there are
        $round = Round::all()
            ->count();

        //if there is a round then do below
        if($round >= 1) {

            //Gets id from table with certain round id --Nick
            $round_table_ids = Table::select('id')
                ->where('round_id', $round_id)
                ->get();

            //Uses PointsCalculator to calculate scores and weight for every table in a certain round --Nick
            $i=0;
            foreach($round_table_ids as $round_table_id){
                $rounds[$i] = PointCalculator::ScoreCalculator($round_table_id);
                $i++;
            }

            //Makes a collection from the rounds sorts by weight and score --Nick & Jennifer
            $collection = collect($rounds);
            $datas = $collection->flatten(1)->sortByDesc('weight')->sortByDesc('score');

            //make an array and set $i --Jennifer
            $ranking[] = [];
            $i = 0;
            //this foreach fills the $ranking array with score, name and rank --Jennifer
            foreach($datas as $data) {

                //Gets f_name and l_name from User where id is player_id --Jennifer
                $player = User::select('f_name', 'l_name')
                    ->where('id', $data['player_id'])
                    ->get();

                //Fills ranking with score, player and rank --Jennifer
                $ranking[$i]['score'] = $data['score'];
                $ranking[$i]['player'] = $player[0]->f_name . ' ' . $player[0]->l_name;
                $ranking[$i]['rank'] = $i + 1;
                $i++;

            }

            //get all rounds ->distinct is get each round one time --Jennifer
            $roundCounter = Table::select('round_id')
                ->distinct('round_id')
                ->get();

            //make an array and set $i --Jennifer
            $counterRounds [] = "";
            $i = 0;
            //this foreach fills the $counterRounds with the rounds --Jennifer
            foreach($roundCounter as $roundCount){

                $counterRounds[$i]  = $roundCount->round_id;
                $i++;
            }

            //set all variables in an array in variable $data --Jennifer
            $data = [
                'counterRounds' => $counterRounds,
                'ranking' => $ranking,
                'id' => $round_id,
             ];

            //return to view and give $data with it --Jennifer
            return view('ranklist.show')->with($data);

        }
        //else redirect to home
        else{
            return redirect(route('home'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
