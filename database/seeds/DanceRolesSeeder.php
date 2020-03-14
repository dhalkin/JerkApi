<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanceRolesSeeder extends Seeder
{
    private $roles = [
        ['Тренер', 'Ведет занятия'],
        ['Студент', 'Посещает занятия'],
        ['Съемщик', 'Берет в субаренду помещение']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role){
            DB::table('dance_roles')->insert([
                'uid' => md5(microtime()),
                'name' => $role[0],
                'about' => $role[1]
            ]);
        }
    }
}
