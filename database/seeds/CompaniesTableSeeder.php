<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
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
            'name' => "Hena's Company",
            'location' => "Ukraine, Kyiv, Lomonosova str",
            'timezone' => "Europe/Kiev",
        ]);
    }
}
