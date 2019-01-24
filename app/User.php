<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Model
{
    use HasApiTokens, Notifiable;


    protected $fillable = [
        'user_id', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
