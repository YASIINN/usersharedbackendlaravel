<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterModel extends Model
{
        protected $table = 'register';
        protected $fillable = ['rname','rlname','rusername','roleid','password','gender','isstudent','cityid','activationcode','runiversity','rphone'];
}
