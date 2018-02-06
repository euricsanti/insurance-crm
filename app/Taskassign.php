<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taskassign extends Model {

    protected $table = 'taskassign';
    protected $fillable = [
        'task_id', 'assigned_user_id','status'
    ];
    public $timestamps = true;

}
