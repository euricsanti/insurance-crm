<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependant extends Model {

    protected $table = 'dependants';
    protected $fillable = [
        'name', 'surname', 'affiliate_no', 'nss', 'user_id', 'registry_date', 'end_contract_date', 'plan_type', 'payment_type', 'policy_id', 'policy_amount', 'relation', 'file_attachment', 'amount_left', 'status'
    ];
    public $timestamps = true;

}
