<?php

 namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Studentlists; 
use Faker\Factory as Faker;

class StudentlistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $courses = ['BBA', 'B.Sc', 'B.Com', 'B.Tech','MBA'];
$faker = Faker::create();

foreach ($courses as $course) {
    for ($i = 0; $i < 30; $i++) {
        DB::table('studentlists')->insert([
            'name' => $faker->name,
            'course' => $course,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}
 }
