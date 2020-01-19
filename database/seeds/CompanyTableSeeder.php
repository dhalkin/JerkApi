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
            'rules' => 'Дорогие друзья! При записи на занятия есть несколько простых правил.
Мы любим порядок и компьютеры, поэтому наш календарь работает полностью автоматически.😁
Обратите внимание на следующую информацию.
- Для записи на занятие вам нужно зарегистрироваться либо войти в свой аккаунт на этой странице.
- Онлайн запись заканчивается за три часа до начала занятия.
- Отменить свой визит возможно за восемь часов до начала занятия.
- По любому вопросу вы можете позвонить администратору 099 000-00-00.

Давайте уважать время друг друга, записывайтесь и приходите, мы всегда рады вас видеть.'
        ]);
    }
}
