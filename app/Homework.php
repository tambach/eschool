<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    public $table = 'homework';

    public function files()
    {
        return $this->hasMany(HomeWorkFiles::class);
    }
}
