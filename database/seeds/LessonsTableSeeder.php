<?php

use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = [
            [
                'id'         => 1,
                'name'       => 'Math',
                'teacher_id' => 1,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '09:00:00',
                'end'   => '09:45:00',
                'lecture_id' => 1
            ],
            [
                'id'         => 2,
                'name'       => 'Chemistry',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '09:50:00',
                'end'   => '10:35:00',
                'lecture_id' => 2
            ],
            [
                'id'         => 3,
                'name'       => 'English',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '10:40:00',
                'end'   => '11:25:00',
                'lecture_id' => 3
            ],
            [
                'id'         => 5,
                'name'       => 'Literature',
                'teacher_id' => 3,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '11:30:00',
                'end'   => '12:15:00',
                'lecture_id' => 4
            ],
            [
                'id'         => 6,
                'name'       => 'French',
                'teacher_id' => 4,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '12:20',
                'end'   => '13:05',
                'lecture_id' => 5
            ],
            [
                'id'         => 7,
                'name'       => 'Biology',
                'teacher_id' => 5,
                'class_id'   => 1,
                'weekday'    => 1,
                'start' => '13:10',
                'end'   => '13:55',
                'lecture_id' => 6
            ],
            [
                'id'         => 4,
                'name'       => 'History',
                'teacher_id' => 3,
                'class_id'   => 2,
                'weekday'    => 1,
                'start' => '14:00',
                'end'   => '14:45',
                'lecture_id' => 7
            ],


            [
                'id'         => 8,
                'name'       => 'Math',
                'teacher_id' => 1,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '09:00',
                'end'   => '09:45',
                'lecture_id' => 1
            ],
            [
                'id'         => 9,
                'name'       => 'Chemistry',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '09:50',
                'end'   => '10:35',
                'lecture_id' => 2
            ],
            [
                'id'         => 10,
                'name'       => 'English',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '10:40',
                'end'   => '11:25',
                'lecture_id' => 3
            ],
            [
                'id'         => 11,
                'name'       => 'Literature',
                'teacher_id' => 3,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '11:30',
                'end'   => '12:15',
                'lecture_id' => 4
            ],
            [
                'id'         => 12,
                'name'       => 'French',
                'teacher_id' => 4,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '12:20',
                'end'   => '13:05',
                'lecture_id' => 5
            ],
            [
                'id'         => 13,
                'name'       => 'Biology',
                'teacher_id' => 5,
                'class_id'   => 1,
                'weekday'    => 2,
                'start' => '13:10',
                'end'   => '13:55',
                'lecture_id' => 6
            ],
            [
                'id'         => 14,
                'name'       => 'History',
                'teacher_id' => 3,
                'class_id'   => 2,
                'weekday'    => 2,
                'start' => '14:00',
                'end'   => '14:45',
                'lecture_id' => 7
            ],



            [
                'id'         => 15,
                'name'       => 'Math',
                'teacher_id' => 1,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '09:00',
                'end'   => '09:45',
                'lecture_id' => 1
            ],
            [
                'id'         => 16,
                'name'       => 'Chemistry',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '09:50',
                'end'   => '10:35',
                'lecture_id' => 2
            ],
            [
                'id'         => 17,
                'name'       => 'English',
                'teacher_id' => 2,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '10:40',
                'end'   => '11:25',
                'lecture_id' => 3
            ],
            [
                'id'         => 18,
                'name'       => 'Literature',
                'teacher_id' => 3,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '11:30',
                'end'   => '12:15',
                'lecture_id' => 4
            ],
            [
                'id'         => 19,
                'name'       => 'French',
                'teacher_id' => 4,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '12:20',
                'end'   => '13:05',
                'lecture_id' => 5
            ],
            [
                'id'         => 20,
                'name'       => 'Biology',
                'teacher_id' => 5,
                'class_id'   => 1,
                'weekday'    => 3,
                'start' => '14:00',
                'end'   => '14:45',
                'lecture_id' => 6
            ],
        ];

        \App\Lesson::insert($lessons);
    }
}
