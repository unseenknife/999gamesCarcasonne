<?php

namespace App\Http\Controllers;

use App\Table;
use App\Player;
use App\Round;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //count how many rounds there are
        $round = Round::all()
            ->count();

        // => Samantha
        $round_table = Table::orderBy('round_id', 'asc')->orderBy('table', 'asc')
            ->get();


        $data = array(
            'title' => 'welkom op tafel',
            'homepageimage' => 'true'
        );

        //if there is a round then do below
        if($round >= 1) {
            return view('tables.index', ['round_table' => $round_table])->with($data);
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
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show($round, $table)
    {
        //Jennifer
        //search in table round_table the table and round_id
        //order this by points (most poinst is first place)
        //joins because you also need the round_player and users table
        //select the collums you want
        $tableRounds = Table::where('table', $table)
            ->where('round_id', $round)
            ->orderBy('round_player.points','desc')
            ->join('round_player', 'round_table_id', 'round_table.id')
            ->join('users', 'users.id', 'round_player.player_id')
            ->select('round_player.id', 'round_player.points', 'users.f_name', 'users.l_name')
            ->get();

        //count how many rounds there are
        $round = Round::all()
            ->count();

        //in the variable data set  variable tableRounds, round and table
        $data = [
            'tableRounds' => $tableRounds,
            'round' => $round,
            'table' => $table
        ];

        //if there is a round then do below
        if($round >= 1) {
            //if variable is empty then return view tafel
            if (!isset($tableRounds[0]->id)) {
                return redirect('/tafel')->with('error', 'Deze ronde bestaat niet');
            } else {
                //return the view with variable data
                return view('tables.show')->with($data);
            }
        }
        //else redirect to home
        else{
            return redirect(route('home'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit($round, $table)
    {
        //Jennifer
        //search in table round_table the table and round_id
        //order this by points (most poinst is first place)
        //joins because you also need the round_player and users table
        //select the collums you want
        $tableRounds = Table::where('table', $table)
            ->where('round_id', $round)
            ->orderBy('round_player.points','desc')
            ->join('round_player', 'round_table_id', 'round_table.id')
            ->join('users', 'users.id', 'round_player.player_id')
            ->select('round_player.id', 'round_player.points', 'users.f_name', 'users.l_name')
            ->get();

        //count how many rounds there are
        $round = Round::all()
            ->count();

        //in the variable data set  variable tableRounds, round and table
        $data = [
            'tableRounds' => $tableRounds,
            'round' => $round,
            'table' => $table
        ];

        //if there is a round then do below
        if($round >= 1) {
            //if variable is empty then return view tafel
            if (!isset($tableRounds[0]->id)) {
                return redirect('/ronde-aanpassen')->with('error', 'Deze ronde bestaat niet');
            } else {
                //return the view with variable data
                return view('tables.edit')->with($data);
            }
        }
        //else redirect to home
        else{
            return redirect(route('home'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $roundid, $tableid)
    {
        //validate the inputs Lex
        $this->validate($request, [
            'player1punten' => 'required',
            'player1id' => 'required',
            'player2punten' => 'required',
            'player2id' => 'required',
            'player3punten' => 'required',
            'player3id' => 'required',
            'player4punten' => 'required',
            'player4id' => 'required'
        ]);



        $roundtableid = Table::select('id')->where('round_id', $roundid)->where('table', $tableid)->first();
        $players = Player::Select('id')->where('round_table_id', $roundtableid->id)->get();

        $i = 1;
        // update the score of all the players in the game Lex
        foreach($players as $player){
            $score = Player::find($player->id);
            $score->points =  $request->input('player' . $i . 'punten');
            $score->save();
            $i++;
         }
        // return them and notify their action was successfull Lex
        return redirect('/ronde-aanpassen')->with('success', 'Ronde succesvol geupdate');
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
    }
}
