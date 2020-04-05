<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DanceCompanySeeder extends Seeder
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
    
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        
        DB::table('dance_companies')->insert([
            'user_id' => 1,
            'uid' => md5(microtime()),
            'name' => 'Студия DiDance',
            'city' => 'Киев',
            'country' => 'Украина',
            'zip' => '03022',
            'address' => 'Братская 6',
            'timezone' => 'Europe/Kiev',
            'last_call_hours'=> 3,
            'refuse_in_hours' => 8,
            'public_available' => true,
            'created_at' => $dateNow,
            'about' => 'Что-то презентативное, короткий текст в две-три строки.
Деятельность.',
            'rules' => '- Запись - не позже, чем за 3 часа до начала занятия.
- Отмена записи - не позже, чем за 8 часов до начала занятия (в противном случае оплата за занятие сгорает).
- Абонемент действует 1 календарный месяц от даты покупки без заморозок.

Вопросы, админ: 099 000-00-00

До встречи на занятиях:)'
        ]);
    }
}
