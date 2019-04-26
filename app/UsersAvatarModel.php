<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersAvatarModel extends Model
{
    protected $table = 'avatar';
    protected $fillable = ['avatar','type','size','date','time'];
}
