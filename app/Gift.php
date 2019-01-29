<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Gift extends Model
{

    protected $table = 'Gift';

    protected $fillable = ['name','image','price','total_amount','current_amount','percent_default','current_percent','type'];


}
