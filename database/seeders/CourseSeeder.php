<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $courses = [
            ['name' => 'BBA'],
            ['name' => 'B.Sc'],
            ['name' => 'B.Com'],
            ['name' => 'B.Tech'],
            ['name' => 'MBA'],
        ];

        // Insert data into the courses table
        DB::table('courses')->insert($courses);    }
}
