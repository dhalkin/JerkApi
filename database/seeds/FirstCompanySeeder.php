<?php


use Illuminate\Database\Seeder;

class FirstCompanySeeder extends Seeder
{
    public const COMPANY_ID = 1;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DirectionsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(HallsTableSeeder::class);
        //$this->call(HallsTableSeeder::class);
    }
}

