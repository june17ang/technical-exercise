<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestfulApi extends Model
{
    protected $table = 'restful_api';

    protected $guard = [
        'key',
        'value'
    ];

    protected $fillable = [
        'key',
        'value',
    ];
}
