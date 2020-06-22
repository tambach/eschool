<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'articles';

    protected $fillable = [
        'title',
        'description',
        'cover',
        'file',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
