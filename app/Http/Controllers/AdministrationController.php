<?php

namespace App\Http\Controllers;
use App\User;
use App\Roles;
use App\Table;
use App\Round;

use Illuminate\Http\Request;

class AdministrationController extends Controller
//Class Lex lextends this content, by having it made
{

    public function __construct()
    {
        //being authenticated is required
        $this->middleware('auth');
    }


    // Differentiate between staff and admins
    public function admin()
    {
        if(User::isAdmin()){//check permissions
            return view('administration.admin');
        }
        else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }
    public function staff()
    {
        if(User::isStaff()){//check permissions
            return view('administration.staff');
        }
        else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    //edit results in case there has been made an error
    public function editRound()
    {
        if(User::isAdmin()){//check permissions

            if(Round::all()->count() == 0){
                return redirect( route('admin') )->with('error','Er is nog geen ronde');
            }

            //Counts the amount of rounds played
            $distinctRoundCounter = Table::select('round_id')->distinct('round_id')->get();


            $roundCounter = Table::distinct('round_id')->count('round_id');

            $x = 1;
            while($x <= $roundCounter){
                $tables[$x] = Table::select('round_id','table')->where('round_id', $x)->get();
                $x++;
            }

            //fill passable array with all needed data
            $data = [
                'rounds' => $distinctRoundCounter,
                'roundcount' => count($tables),
                'tables' => $tables
            ];
            return view('administration.editresults')->with($data);
        }
        else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    public function UserManagement() //List all current users
    {
        if(User::isAdmin()){//check permissions

            $data = [
                'users' => User::all()
            ];

            //return $data;
            return view('administration.users')->with($data);
        }
        else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    public function UserManagementEdit(User $user)
    {
        if(User::isAdmin()){//check permissions

            $data = [
                'user' => $user,                
                'roles' => Roles::all()
            ];

            //return $data;
            return view('administration.user')->with($data);
        }
        else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    public function UpdateUserEdit(Request $request, User $user)
    {
        if(User::isAdmin()){//check permissions
            $this->validate($request, [
                    'f_name' => 'required',
                    'l_name' => 'required',
                    'email' => 'required',
                    'phone_nr' => 'required',
                    'roleid' => 'required'
             ]);

             // insert new data
             $user->f_name = $request->input('f_name');
             $user->l_name = $request->input('l_name');
             $user->email = $request->input('email');
             $user->phone_nr = $request->input('phone_nr');
             $user->roleid = $request->input('roleid');
             $user->updated_at = now()->timestamp;

             $user->save();
             //notify user that it was succesfull
         return redirect('/users')->with('success', 'Gebruiker successvol geupdate');
         }
         else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    public function DeleteUserEdit(Request $request, User $user)
    {
        if(User::isAdmin()){//check permissions

             $user->delete();
             //user poofed gone

         return redirect('/users')->with('success', 'Gebruiker successvol verwijderd');
         }
         else{
            return redirect('/')->with('error', 'Je hebt niet voldoende rechten.');
        }
    }

    public function indeling()
    {
        
        $playerss = \App\User::select('id')->where('roleid', 2)->get();


        $counter = 0;
        foreach($playerss as $player){
            $playersss[$counter]['player_id'] = $player->id;
            $counter++;
        }
        $players = collect($playersss);

 
        if(\App\Round::all()->count() > 0){
            $round_table_ids = \App\Table::all();

            $chunkRounds = \App\Round::all()->count();

            $i=0;

            foreach($round_table_ids as $round_table_id){
                $rounds[$i] = \App\Http\Services\PointCalculator::ScoreCalculator($round_table_id);
                $i++;
            }

            $collection = collect($rounds);
            $datas = $collection->flatten(1)->sortByDesc('player_id')->chunk($chunkRounds);

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

            }

            $collection2 = collect($total);
            $players = $collection2->sortByDesc('weight')->sortByDesc('score');
        }
        //return $players;

        if(\App\Round::all()->count() == 4){
            $players = $players->take(16);
        }
        if(\App\Round::all()->count() == 5){
            $players = $players->take(8);
        }
        if(\App\Round::all()->count() == 6){
            $players = $players->take(4);
        }
        if(\App\Round::all()->count() == 7){
            $players = $players->take(2);
        }
        if(\App\Round::all()->count() > 7){
            return redirect(route('home'))->with('error', "Het NK is al afgelopen, we kunnen geen nieuwe ronde starten");
        }

        $tableFiller = new \App\Http\Services\tableFiller();

        $tables = $tableFiller->calculateTables($players);
        return $tables;
    }

}
