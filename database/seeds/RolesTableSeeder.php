<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    private $roles = [
        'Owner',
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
            DB::table('roles')->insert([
                'name' => $role
            ]);
        }
    }
}
