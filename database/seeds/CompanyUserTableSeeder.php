<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyUserTableSeeder extends Seeder
{
    private $directions = [
        'Trainer One',
        'Trainer Two',
        'Trainer Three'
    ];
    
    private $clients = [
        'Client One',
        'Client Two',
        'Client Three'
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
            DB::table('company_users')->insert([
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'first_name' => $role,
                'phone' => '38096666666' . ++$i,
                'role_id' => 1, // trainer
                'password' => '$2y$10$rQZiMjlSfjCTQtqGUDTsq.WYRgKFIKUbMUArwdBA863Kp63UG3DTm', // 0000
                'api_token' => Str::random(60),
                'active' => 1
            ]);
        }
    
        foreach ($this->clients as $role){
            DB::table('company_users')->insert([
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'first_name' => $role,
                'phone' => '38096666666' . ++$i,
                'role_id' => 1, // trainer
                'password' => '$2y$10$rQZiMjlSfjCTQtqGUDTsq.WYRgKFIKUbMUArwdBA863Kp63UG3DTm', // 0000
                'api_token' => Str::random(60),
                'active' => 1
            ]);
        }
        
    }
}
