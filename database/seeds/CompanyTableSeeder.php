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
            'name' => 'Студия DiDance',
            'city' => 'Киев',
            'country' => 'Украина',
            'zip' => '03022',
            'address' => 'Братская 6',
            'timezone' => 'Europe/Kiev',
            'last_call_hours'=> 3,
            'refuse_in_hours' => 8,
            'rules' => '
<ul>
<li>Запись - не позже, чем за 3 часа до начала занятия</li>

<li>Отмена записи - не позже, чем за 8 часов до начала занятия (в противном случае оплата за занятие сгорает)</li>

<li>Абонемент действует 1 календарный месяц от даты покупки без заморозок.</li>
</ul>
<p>
Вопросы, админ: 099 000-00-00
</p>
<p>До встречи на занятиях:)</p>
'
        ]);
    }
}
