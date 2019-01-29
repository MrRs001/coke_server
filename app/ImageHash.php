<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageHash extends Model
{
    //
    protected $table = 'ImageHash';

    protected $fillable = ['hash_content'];
}
