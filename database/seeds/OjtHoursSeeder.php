<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OjtHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hours')->insert([
            'bsit'          => 0,
            'bit'           => 0,
            'academicYear'  => Carbon::today()->subYear()->format('Y').'-'.Carbon::today()->format('Y')
        ]);
    }
}
