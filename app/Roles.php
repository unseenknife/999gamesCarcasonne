<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    protected $table = 'roles';

    public $primaryKey = 'id';

    public $timestamps = true;

    public function user()
{
    return $this->hasMany('App\User');
}

}
