<?php

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    private $timezones = [
        'South-West'       => "Sumgaitskaya str. 14",
        'The Moon'             => "Lunacharskogo str. 100",
        'Mytnitza'            => "Kalinina str. 36"
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->timezones as $name => $zone){
            DB::table('branches')->insert([
                'unique_id' => md5(microtime()),
                'company_id' => 1,
                'name' => $name,
                'address' => $zone,
            ]);
        }
    }
}
