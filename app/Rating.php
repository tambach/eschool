<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $table = 'rating';


    public function student()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }
}
