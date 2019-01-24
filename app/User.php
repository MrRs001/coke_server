<?php

namespace App;

use Laravel\Passport\HasApiTokens;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;

    // protected $id = ['user_id'];
    // protected $password = ['password'];
}
