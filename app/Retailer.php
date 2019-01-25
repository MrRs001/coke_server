<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Retailer extends Model
{
    use Notifiable, HasApiTokens;
    protected $table = 'Customer';

    protected $fillable = ['contract_id','sales','user_id', 'image'];
}
