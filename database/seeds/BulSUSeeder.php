<?php

use Illuminate\Database\Seeder;

class BulSUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name'      => 'Bulacan State University - Sarmiento Campus',
            'address'   => 'Kaypian Road, City of San Jose Del Monte Bulacan',
            'latitude'  => '14.814173',
            'longitude' => '121.057059',
            'deleted'   => '0'
        ]);
    }
}
