<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*added phoneNr, fName, lName->kimberley*/
    public $fillable = [
        'f_name', 'l_name', 'email', /*'password', */'roleid', 'phone_nr',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Roles', 'roleid');
    }

    static function GetUserNameById($id){

        return user::find($id)->name;

    }
    static function isAdmin()
    {
        if (Auth()->user()->roleid == 3 || Auth()->user()->roleid == 4){
            return true;
        }
        else {
            return false;
        }
    }
    static function isStaff()
    {
        if (Auth()->user()->roleid == 3) {
            return true;
        } else {
            return false;
        }
    }

}
