<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankaccounts extends Model {

    protected $table = 'bankaccounts';
    protected $fillable = [
        'bank_name', 'balance'
    ];
    public $timestamps = true;

}
