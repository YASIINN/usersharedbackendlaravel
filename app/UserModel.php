<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';
        protected $fillable = ['username','usname','uslname','roleid','avatarid','token','gender','city','isstudent','universityid'];
        protected $hidden = [
            'password', 'token',
        ];

    }
