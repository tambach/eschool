<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeworkFiles extends Model
{
    public $table = 'homework_files';

    protected $fillable = ['filename', 'mime', 'path', 'size', 'student_id', 'homework_id'];
}
