<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $nameOfRole = RolesController::GetRoleName(auth()->user()->roleid);
        return view('dashboard')->with('role', $nameOfRole);
    }
}
