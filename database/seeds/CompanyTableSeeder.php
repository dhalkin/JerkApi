<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Kate',
            'second_name' => 'Danilova',
            'phone' => '380000000000',
            'email'=> 'shandy.kate@gmail.com',
            'role_id' => 1, // admin
            'password' => '$2y$10$rQZiMjlSfjCTQtqGUDTsq.WYRgKFIKUbMUArwdBA863Kp63UG3DTm', // 0000
            'api_token' => Str::random(60),
            'active' => 1
        ]);
        
        DB::table('companies')->insert([
            'user_id' => 1,
            'unique_id' => 'c5d3c76de69f35b003d3b4f187455c40',
            'name' => 'DDance',
            'city' => 'Киев',
            'country' => 'Украина',
            'zip' => '03022',
            'address' => 'Братская 6',
        ]);
    }
}
