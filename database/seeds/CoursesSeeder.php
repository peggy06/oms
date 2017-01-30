<?php

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'name'      => 'Bachelor Of Science In Information Technology',
            'shortname' => 'Information Technology',
            'code'      => 'IT',
            'available' => 1,
            'deleted'   => 0
        ]);

        DB::table('courses')->insert([
            'name'      => 'Bachelor Of Industrial Technology',
            'shortname' => 'Industrial Technology',
            'code'      => 'BIT',
            'available' => 0,
            'deleted'   => 0
        ]);
    }
}
