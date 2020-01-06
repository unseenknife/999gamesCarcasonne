<?php

namespace App\Http\Controllers;

use App\Round;
use App\Table;
use App\Player;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PointAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Round::all()->count() == 0){
                if(Auth::user()->roleid == 3){
                    return redirect( route('staff') )->with('error','Er is nog geen ronde');
                }else{
                    return redirect( route('admin') )->with('error','Er is nog geen ronde');
                }
                
        }

        //Gets the id from Round --Nick
        $rounds = Round::select('id')
            ->distinct('id')
            ->get();

        //Puts round ids for every round in an array --Nick
        $i = 0;
        $counterRounds [] = "";
        foreach($rounds as $roundCount){

            $counterRounds[$i]  = $roundCount->id;
            $i++;

        }

        $counterTables = "";
        $round_id = "";
        $players = "";
        $table_id = "";

        //Fills $data with both of the array's --Nick
        $data = [
            'counterRounds' => $counterRounds,
            'counterTables' => $counterTables,
            'tableRounds' => $players,
            'round_id' => $round_id,
            'table_id' => $table_id
        ];

        return view('score.create')->with($data);
    }

    public function round($round_id)
    {
        //Gets the id from Round --Nick
        $rounds = Round::select('id')
            ->distinct('id')
            ->get();

        //Puts round ids for every round in an array --Nick
        $i = 0;
        $counterRounds [] = "";
        foreach($rounds as $roundCount){

            $counterRounds[$i]  = $roundCount->id;
            $i++;

        }

        //Gets table and id from Table by join between round_id and id from Round and Table
        //distinct id from Table --Nick
        $tables = Round::select('round_table.table', 'round_table.id')
            ->join('round_table', 'round_table.round_id', 'rounds.id')
            ->where('round_table.round_id', '=', $round_id)
            ->distinct('round_table.id')
            ->get();

        //Puts tables for every table in an array --Nick
        $i = 0;
        $counterTables[] = "";
        foreach ($tables as $tableCount) {

            $counterTables[$i] = $tableCount->table;
            $i++;

        }

        $players = "";
        $table_id = "";

        //Fills $data with both of the array's --Nick
        $data = [
            'counterRounds' => $counterRounds,
            'counterTables' => $counterTables,
            'tableRounds' => $players,
            'round_id' => $round_id,
            'table_id' => $table_id
        ];

        //Only redirects you to the right view when you get there by the right route --Nick
        if(isset($tables[0]->id))
        {
            return view('score.create')->with($data);
        }
        else{
            return redirect('/score/create')->with('error', 'Deze ronde bestaat niet');
        };
    }

    public function table($round_id, $table_id)
    {
        //Gets the id from Round --Nick
        $rounds = Round::select('id')
            ->distinct('id')
            ->get();

        //Puts round ids for every round in an array --Nick
        $i = 0;
        $counterRounds [] = "";
        foreach($rounds as $roundCount){

            $counterRounds[$i]  = $roundCount->id;
            $i++;

        }

        //Gets id from Table with certain table and round ids --Nick
        $round_table_id = Table::select('id')
            ->where('table', '=', $table_id)
            ->where('round_id', '=', $round_id)
            ->get();

        //Gets table and id from Table by join between round_id and id from Round and Table
        //distinct id from Table --Nick
        $tables = Round::select('round_table.table', 'round_table.id')
            ->join('round_table', 'round_table.round_id', 'rounds.id')
            ->where('round_table.round_id', '=', $round_id)
            ->distinct('round_table.id')
            ->get();

        //Puts tables for every table in an array --Nick
        $i = 0;
        $counterTables[] = "";
        foreach ($tables as $tableCount) {

            $counterTables[$i] = $tableCount->table;
            $i++;

        }

        //Gets player info from round table ids --Nick
        $players = Player::select('round_player.id', 'round_player.player_id', 'users.f_name', 'users.l_name', 'round_player.points')
            ->where('round_player.round_table_id', '=', $round_table_id[0]->id)
            ->join('users', 'users.id', 'round_player.player_id')
            ->distinct('round_player.id')
            ->get();

        //Fills $data with both of the array's --Nick
        $data = [
            'counterRounds' => $counterRounds,
            'counterTables' => $counterTables,
            'tableRounds' => $players,
            'round_id' => $round_id,
            'table_id' => $table_id
        ];

        //Only redirects you to the right view when you get there by the right route --Nick
        if(isset($players[0]->id))
        {
            return view('score.create')->with($data);
        }
        else{
            return redirect('/score/create')->with('error', 'Deze combinatie van ronde en tafel bestaat niet');
        };

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Gets id from Table with certain table and round ids --Nick
        $round_table_id = Table::select('id')
            ->where('table', '=', $request->input('table_id'))
            ->where('round_id', '=', $request->input('round_id'))
            ->get();

        //Gets player info from round table ids --Nick
        $players = Player::select('player_id')
            ->where('round_table_id', '=', $round_table_id[0]->id)
            ->get();

        //Saves the points to all the players on a certain table with an foreach --Nick
        $i = 1;
        foreach($players as $player)
        {
            $result = Player::select('*')
                ->where('player_id',$player->player_id)
                ->where('round_table_id', '=', $round_table_id[0]->id)
                ->get();
            $result->first()->points = $request->input('player' . $i . 'punten');
            $result[0]->save();
            $i++;
        }


        return redirect('/score/create')->with('success','Score is succesvol ingevoerd');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
