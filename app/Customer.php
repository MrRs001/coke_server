<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'Customer';
    protected $fillable = [
        'customer_code',
        'name',
        'sales_office',
        'distribute_code',
        'city',
        'district',
        'street',
        'contact_first_name',
        'sales_rep',
        'telephone',
        'mobile',
        'trade_channel',
        'customer_channel',
        'customer_category',
        'sub_trade_channel',
        'key_acc'
    ];
}
