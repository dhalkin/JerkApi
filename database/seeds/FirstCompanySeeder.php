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
        $this->call(DanceCompanySeeder::class);
        $this->call(DanceRolesSeeder::class);
        $this->call(DanceCompanyUserSeeder::class);
        $this->call(DanceBranchesSeeder::class);
        $this->call(DanceHallsSeeder::class);
        $this->call(DanceDirectionsSeeder::class);
        $this->call(DanceGroupsSeeder::class);
        
    }
}

