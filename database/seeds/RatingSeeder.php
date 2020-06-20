<?php

use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 40; $i++)
        {
            $date =  $faker->unique()->dateTimeBetween($startDate = '-1 years', $endDate = 'now');
            \App\rating::create([
                'grade'     => random_int(1, 10),
                'user_id'   => 1,
                'lesson_id' => random_int(1, 7),
                'date'      => $date,
                'updated_at' => now(),
                'created_at' => $date,
            ]);
        }
    }
}
