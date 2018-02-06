<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

    protected $table = 'ratings';
    protected $fillable = [
        'dependant_id', 'rating', 'rating_note'
    ];
    public $timestamps = true;

}
