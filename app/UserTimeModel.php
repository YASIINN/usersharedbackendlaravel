<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTimeModel extends Model
{
    protected $table = 'usertime';
    protected $fillable = [
        'usid', 'logintime','logouttime','ip','logindate','logoutdate'
    ];
}
