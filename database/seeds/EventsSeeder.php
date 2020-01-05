<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    private $directions = [
        'Exotic pole dance',
        'Pole Dance',
        'Pole Kids',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start =  Carbon::yesterday();
        $start->hour(10)->minute(30);
    
        $finish = $start->copy()->addHours(2);
    
        for ($x = 0; $x <= 3; $x++) {
        
            DB::table('events')->insert([
                'start' => $start,
                'finish' => $finish,
                'group_id' => rand(1, 3),
                'hall_id' => rand(1,3),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'trainer_id' =>  null,
                'active' => true
            ]);
        
            $start = $start->addHours(2);
            $finish = $finish->addHours(2);
        }
        
        $start =  Carbon::now();
        $start->hour(7)->minute(30);
        
        $finish = $start->copy()->addHours(2);

        for ($x = 0; $x <= 3; $x++) {
            
            DB::table('events')->insert([
                'start' => $start,
                'finish' => $finish,
                'group_id' => rand(1, 3),
                'hall_id' => rand(1,3),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'active' => true
            ]);

            $start = $start->addHours(2);
            $finish = $finish->addHours(2);
        }
        
    }
}
