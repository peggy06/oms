<?php

use Illuminate\Database\Seeder;

class statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('serverStatus')->insert([
            'server_status'   => 1
        ]);    }
}
