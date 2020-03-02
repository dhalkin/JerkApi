<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanceGroupsSeeder extends Seeder
{
    private $dance_groups = [
        'Exotic pole dance',
        'Pole Dance',
        'Pole junior (от 12ти)',
        'Pole Kids (от 6ти)',
        'Pole Plastic',
        'Stretching',
        'TRX',
        'Инд 1 чел/час',
        'Инд 2 чел/час',
        'Пилатес',
        'Постановки',
        'Фитнес'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->dance_groups as $role){
            DB::table('dance_groups')->insert([
                'name' => $role,
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'default_trainer_id' => rand(1, 3),
                'color_id' => rand(1, 9),
                'duration_min' => 60,
                'max_person' => 12
            ]);
        }
    }
}
