<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'user_id' => 1,
            'unique_id' => 'c5d3c76de69f35b003d3b4f187455c40',
            'name' => 'Kate Company',
            'city' => 'Киев',
            'country' => 'Украина',
            'zip' => '03022',
            'address' => 'Братская 6',
        ]);
    }
}
