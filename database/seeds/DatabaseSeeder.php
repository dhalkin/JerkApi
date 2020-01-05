<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TimezonesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolesCompanyUserTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        
        
        //$this->call(CompaniesTableSeeder::class);
       // $this->call(HallsTableSeeder::class);
    }
}
