<?php

namespace App\Http\Controllers;

use App\Laravue\Models\User;
use App\Lecture;
use App\Lesson;
use App\Rating;
use App\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getAllScores(Request $request)
    {
        $lesson_id = $request['lesson_id'];
        $rating = Rating::join('users', 'rating.user_id', '=', 'users.id')->where('lesson_id', $lesson_id)->orderBy('date', 'desc')->get();
        $avg = Rating::where('lesson_id', $lesson_id)->pluck('grade')->avg();
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

    public function getAverage(Request $request)
    {
        $user_id   = $request['user_id'];

        $average = DB::table('rating')
            ->select('lesson_id', 'lessons.name', DB::raw('round(AVG(grade), 1) as grade'), DB::raw('round(RAND()*(100-1)+1, 0) as attendance'))
            ->join('lessons', 'rating.lesson_id', '=', 'lessons.id')
            ->where('user_id', $user_id)
            ->groupBy('lesson_id')
            ->get();

        return response(['data' => $average ], 200);
    }

    public function getClasses(Request $request)
    {
        $class = SchoolClass::all();

        return response(['data' => $class ], 200);
    }

    public function getLessonByClass(Request $request)
    {
        $class = $request->class;
        $data = Lecture::where('class_id', $class)->get();

        return response(['data' => $data ], 200);
    }

    public function getratingByLesson(Request $request)
    {
        $lesson = $request->lesson;

    }
}
