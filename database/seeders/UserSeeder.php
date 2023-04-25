<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Administrator',
            'slug'      => 'administrator',
            'email'     => 'islamic.center.kaltim99@gmail.com',
            'username'     => 'Admin!',
            'celuller_no'     => '08115986878',
            'masterstatus'     => '1',
            'email_verified_at' => now(),
            'password' => bcrypt('secret12'),
            'remember_token' => Str::random(30),
        ]);
    }
}
