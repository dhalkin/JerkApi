<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionsTableSeeder extends Seeder
{
    private $directions = [
        'Exotic pole dance',
        'Pole Dance',
        'Pole Kids',
        'Stretching',
        'TRX',
        'Воздух',
        'Инд 1 чел/час',
        'Инд 2 чел/час',
        'Пилатес',
        'Постановки'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->directions as $role){
            DB::table('directions')->insert([
                'name' => $role,
                'trainer_id' => random_int(1, 3),
                'company_id' => FirstCompanySeeder::COMPANY_ID
            ]);
        }
    }
}
