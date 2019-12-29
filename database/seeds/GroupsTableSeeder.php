<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    private $groups = [
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
        foreach ($this->groups as $role){
            DB::table('groups')->insert([
                'name' => $role,
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'direction_id' => rand(1, 9),
                'duration_min' => 60,
                'max_person' => 12
            ]);
        }
    }
}
