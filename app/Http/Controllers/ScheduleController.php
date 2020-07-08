<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getList(Request $request)
    {
        $count = 0;
        $user_id   = $request['user_id'];
        $user = User::find($user_id);
        $lessons = $user->class->classLessons;

        $timeRange = $this->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $weekDays     = Lesson::WEEK_DAYS;
        //return response(['data' => $lessons, 'count' => $count], 200);

        $time_index = 0;
        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('weekday', $index)->where('start', '>=', $time['start'])->where('end', '<=', $time['end'])->first();

                if ($lesson)
                {
                    $teacher = User::find($lesson->teacher_id);
                    $count++;
                    $calendarData[$timeText]['time'] = $timeText;
                    $calendarData[$timeText][$day] = $lesson->name  .', '. $teacher->name;
                    $calendarData[$timeText]['teacher'] = $teacher->name .', '. $teacher->name;
                }
                else
                {
                    $calendarData[$timeText]['time'] = $timeText;
                    $calendarData[$timeText][$day] = '';
                }
            }
            $time_index++;
        }

        return response(['data' => $calendarData, 'count' => $count, 'tmrange'=>$lessons], 200);
    }

    public function getTeacherList(Request $request)
    {
        $count = 0;
        $user_id   = $request['user_id'];
        $lessons = Lesson::where('teacher_id', $user_id)->get();

        $timeRange = $this->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $weekDays     = Lesson::WEEK_DAYS;
        //return response(['data' => $lessons, 'count' => $count], 200);

        $time_index = 0;
        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('weekday', $index)->where('start', '>=', $time['start'])->where('end', '<=', $time['end'])->first();

                if ($lesson)
                {
                    $teacher = User::find($lesson->teacher_id);
                    $count++;
                    $calendarData[$timeText]['time'] = $timeText;
                    $calendarData[$timeText][$day] = $lesson->class_id  .' კლასი';
                    $calendarData[$timeText]['teacher'] = $teacher->name .', '. $teacher->name;
                }
                else
                {
                    $calendarData[$timeText]['time'] = $timeText;
                    $calendarData[$timeText][$day] = '';
                }
            }
            $time_index++;
        }

        return response(['data' => $calendarData, 'count' => $count, 'tmrange'=>$lessons], 200);
    }

    public function generateTimeRange($from, $to)
    {
        $time = Carbon::parse($from);
        $timeRange = [];

        do
        {
            array_push($timeRange, [
                'start' => $time->format("H:i"),
                'end' => $time->addMinutes(50)->format("H:i")
            ]);
        } while ($time->format("H:i") !== $to);

        return $timeRange;
    }

    public function generateCalendarData($weekDays)
    {
        $calendarData = [];
        $timeRange = $this->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons   = Lesson::with('class', 'teacher')
            ->calendarByRoleOrClassId()
            ->get();

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('weekday', $index)->where('start_time', $time['start'])->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->class->name,
                        'teacher_name' => $lesson->teacher->name,
                        'rowspan'      => $lesson->difference/30 ?? ''
                    ]);
                }
                else if (!$lessons->where('weekday', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
