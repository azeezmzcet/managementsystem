<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Random password generation for the principal
        $principalPassword = Str::random(10); // Generate a random 10-character password

        // Insert the principal record
        DB::table('users')->insert([
            'username' => '',
            'password' => bcrypt($principalPassword), // Hash the password
            'role' => 'principal',
            'course' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optional: Insert a teacher record for testing
        // DB::table('users')->insert([
        //     'username' => 'teacher1',
        //     'password' => bcrypt('teacherPassword123'), // You can set a specific password for testing
        //     'role' => 'teacher',
        //     'course' => 'Mathematics',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Output the random password for reference
        echo "Principal password: " . $principalPassword . "\n";
    }
}
