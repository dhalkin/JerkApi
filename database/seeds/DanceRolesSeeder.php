<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanceRolesSeeder extends Seeder
{
    private $roles = [
        'Trainer',
        'Student',
        'Renter'
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
                'name' => $role
            ]);
        }
    }
}
