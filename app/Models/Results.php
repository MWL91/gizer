<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Results extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['id', 'user', 'score', 'finished_at'];
    public $timestamps = false;
}
