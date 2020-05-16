<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestfulApi extends Model
{

    protected $guard = [
        'key',
        'value'
    ];

    protected $fillable = [
        'key',
        'value',
    ];
}
