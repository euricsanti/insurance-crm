<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $table = 'due_payments';
    protected $fillable = [
        'title', 'duedate', 'reference', 'user_id', 'user_name'
    ];
    public $timestamps =

    true;

    }
