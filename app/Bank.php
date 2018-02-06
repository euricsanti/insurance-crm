<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

    protected $table = 'banks';
    protected $fillable = [
        'bank_name', 'user_id', 'user_name','balance','bk_account_number'
    ];
    public $timestamps = true;

}
