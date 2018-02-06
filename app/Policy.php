<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model {

    protected $table = 'policies';
    protected $fillable = [
        'type_of_policy', 'policy_no', 'insurance_company', 'total_payment_amount', 'user_id'
    ];
    public $timestamps = true;

}
