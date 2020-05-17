<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DanceCompanyUserSeeder extends Seeder
{
    private $directions = [
        'Trainer One',
        'Trainer Two',
        'Trainer Three'
    ];
    
    private $clients = [
        'Student One',
        'Student Two',
        'Student Three'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        foreach ($this->directions as $role){
            DB::table('dance_company_users')->insert([
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'first_name' => $role,
                'phone' => '38098626266' . ++$i,
                'role_id' => 1, // trainer
                'password' => '$2y$10$rQZiMjlSfjCTQtqGUDTsq.WYRgKFIKUbMUArwdBA863Kp63UG3DTm', // 0000
                'api_token' => Str::random(60),
                'active' => 1
            ]);
        }
    
        foreach ($this->clients as $role){
            DB::table('dance_company_users')->insert([
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'first_name' => $role,
                'phone' => '38096365626' . ++$i,
                'role_id' => 2, // student
                'password' => '$2y$10$rQZiMjlSfjCTQtqGUDTsq.WYRgKFIKUbMUArwdBA863Kp63UG3DTm', // 0000
                'api_token' => Str::random(60),
                'active' => 1
            ]);
        }
        
    }
}
