<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanceHallsSeeder extends Seeder
{
    private $dance_groups = [
        ['Space #1', 1],
        ['Space #2', 1],
        ['Большой Зал', 2],
        ['Маленький Зал',2]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->dance_groups as $role){
            DB::table('dance_halls')->insert([
                'uid' => md5(microtime()),
                'branch_id' => $role[1],
                'name' => $role[0],
                'active' => true
            ]);
        }
    }
}
