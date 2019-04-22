<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordModel extends Model
{
    protected $table="password";
    protected $fillable = [
        'passwordtxt', 'userid',
    ];
}
