<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manage_pos extends Model
{
    protected $table = 'manage_pos';
    protected $fillable = [
        'open_pos_id', 'user_id', 'created', 'wake_time', 'sleep_time', 'status'
    ];
    public $timestamps = true;
}
