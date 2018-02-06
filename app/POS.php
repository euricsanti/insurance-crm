<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POS extends Model {

    protected $table = 'point_of_sales';
    protected $fillable = [
        'pos_dependant_id', 'pos_policy_id', 'pos_type_of_payment', 'pos_amount','posbankinfo', 'pos_refrence', 'pos_date', 'user_id'
    ];
    public $timestamps = true;

}
