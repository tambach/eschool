<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $table = 'books';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'cover',
        'file',
        'class_id',
        'teacher_id',
        'created_at',
        'updated_at',
    ];
}
