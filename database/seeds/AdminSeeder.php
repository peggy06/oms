<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' =>  'OMS',
            'lastname'  =>  'Admin',
            'name'      =>  'OMS Admin',
            'email'     =>  'ojtmonitoring@gmail.com',
            'password'  =>  bcrypt('password'),
            'role'      =>  1,
        ]);

        DB::table('profiles')->insert([
            'user_id'   => '1',
            'avatar'    => '/images/avatar_male_adviser.png',
            'bday'      => '2016-11-15 02:32:16',
            'gender'    => 0,
            'contact'   => '9123150248',
            'deleted'   => 0
        ]);

        DB::table('signatures')->insert([
            'user_id'   => 1,
            'signature' => strtoupper(\Illuminate\Support\Str::random(12)),
            'role'      => 4,
            'deleted'   => 0
        ]);
    }
}
