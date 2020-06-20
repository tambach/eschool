<?php

namespace App\Http\Controllers;

use App\Laravue\Models\User;
use App\Lesson;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function getList(Request $request)
    {
        $user_id   = $request['user_id'];
        $lesson_id = $request['lesson_id'];
        $user = User::find($user_id);
        $rating = $user->rating->where('lesson_id', $lesson_id)->sortBy('date');
        $avg = $user->rating->where('lesson_id', $lesson_id)->pluck('grade')->avg();
        $lesson_name = Lesson::where('id', $lesson_id)->first();
        return response(['data' => $rating, 'lesson' => $lesson_name->name, 'average' => $avg], 200);
    }

    public function getUserLessons(Request $request)
    {
        $user_id   = $request['user_id'];
        $user = User::find($user_id);
        $lessons = $user->class->lectures;
        $average = $user->rating->pluck('grade')->avg();

        return response(['data' => $lessons, 'average' => $average], 200);

    }
}
