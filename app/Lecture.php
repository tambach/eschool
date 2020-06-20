<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public $table = 'lectures';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'class_id',
        'teacher_id',
        'created_at',
        'updated_at',
    ];
}
