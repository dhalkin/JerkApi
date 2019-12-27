<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesCompanyUserTableSeeder extends Seeder
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
            DB::table('roles_company_users')->insert([
                'name' => $role
            ]);
        }
    }
}
