<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallsTableSeeder extends Seeder
{
    private $groups = [
        ['Space #1 на Подоле', 'ул. Братская 6'],
        ['Space #2 на Подоле','ул. Братская 6'],
        ['Большой Зал на Виноградаре','ул. проспект Правды 12в'],
        ['Маленький Зал на Виноградаре','ул. проспект Правды 12в']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->groups as $role){
            DB::table('halls')->insert([
                'unique_id' => md5(microtime()),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'name' => $role[0],
                'address' => $role[1],
                'active' => true
            ]);
        }
    }
}
