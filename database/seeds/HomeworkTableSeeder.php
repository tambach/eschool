<?php

use Illuminate\Database\Seeder;

class HomeworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 20; $i++)
        {
            $date =  $faker->unique()->dateTimeBetween($startDate = '-1 years', $endDate = 'now');
            \App\Homework::create([
                'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'teacher_id'  => random_int(1, 3),
                'lesson_id'   => random_int(1, 7),
                'date'        => $date,
                'updated_at'  => now(),
                'created_at'  => $date,
            ]);
        }
    }
}
