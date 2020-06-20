<?php

use Illuminate\Database\Seeder;

class LecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lectures = [
            [
                'id'         => 1,
                'name'       => 'Math',
                'teacher_id' => 1,
                'class_id'   => 1,
            ],
            [
                'id'         => 2,
                'name'       => 'Chemistry',
                'teacher_id' => 2,
                'class_id'   => 1,
            ],
            [
                'id'         => 3,
                'name'       => 'English',
                'teacher_id' => 2,
                'class_id'   => 1,
            ],
            [
                'id'         => 4,
                'name'       => 'History',
                'teacher_id' => 3,
                'class_id'   => 2,
            ],
            [
                'id'         => 5,
                'name'       => 'Literature',
                'teacher_id' => 3,
                'class_id'   => 1,
            ],
            [
                'id'         => 6,
                'name'       => 'French',
                'teacher_id' => 4,
                'class_id'   => 1,
            ],
            [
                'id'         => 7,
                'name'       => 'Biology',
                'teacher_id' => 5,
                'class_id'   => 1,
            ],
            ];

        \App\Lecture::insert($lectures);

    }
}
