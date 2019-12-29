<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallsTableSeeder extends Seeder
{
    private $groups = [
        ['Зал "Ласточка" на Оболони', 'Оболонский проспект 48, офис 5'],
        ['Blue Origin на Васильковской','Васильковская 34, вход со двора'],
        ['Зал "No Name" Голосеевский','ул. Джона Маккейна']
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
