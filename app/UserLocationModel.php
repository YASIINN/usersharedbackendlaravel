<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocationModel extends Model
{
    protected $table = 'userlocation';
    protected $fillable = ['usid','locationname','locationcoord','ip'];
}
