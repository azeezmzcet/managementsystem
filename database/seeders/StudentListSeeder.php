<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StudentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = ['BBA', 'B.Sc', 'B.Com', 'B.Tech', 'MBA'];
        $faker = Faker::create();

        foreach ($courses as $course) {
            for ($i = 0; $i < 30; $i++) {
                DB::table('student_list')->insert([
                    'name' => $faker->name,
                    'course' => $course,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
