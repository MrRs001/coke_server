<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'ContractInfo';

    protected $fillable = [
        'contract_id',
        'distribute_code',
        'sales',
        'image',
        'hash_image',
        'gift_id',
        'gift_type',
        'u_name',
        'u_phone',
        'u_address'
    ];

}
