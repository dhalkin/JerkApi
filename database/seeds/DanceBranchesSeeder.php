<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanceBranchesSeeder extends Seeder
{
    private $branches = [
        ['Подол', 'Братская 6'],
        ['Виноградарь','проспект Правды 12в']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->branches as $role){
            DB::table('dance_branches')->insert([
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'uid' => md5(microtime()),
                'name' => $role[0],
                'address' => $role[1],
                'active' => true
            ]);
        }
    }
}
