<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DanceEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start =  Carbon::yesterday();
        $start->hour(10)->minute(30);
    
        $finish = $start->copy()->addHours(1);
    
        for ($x = 0; $x <= 3; $x++) {
        
            DB::table('dance_events')->insert([
                'start' => $start,
                'finish' => $finish,
                'group_id' => rand(1, 12),
                'hall_id' => rand(1,4),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'trainer_id' =>  rand(1,3),
                'active' => true
            ]);
        
            $start = $start->addHours(2);
            $finish = $finish->addHours(2);
        }
        
        $start =  Carbon::now();
        $start->hour(7)->minute(30);
        
        $finish = $start->copy()->addHours(1)->addMinutes(30);

        for ($x = 0; $x <= 3; $x++) {
            
            DB::table('dance_events')->insert([
                'start' => $start,
                'finish' => $finish,
                'group_id' => rand(1, 12),
                'hall_id' => rand(1,4),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'trainer_id' =>  rand(1,3),
                'active' => true
            ]);

            $start = $start->addHours(4);
            $finish = $finish->addHours(4);
        }
    
        $start =  Carbon::tomorrow();
        $start->hour(11)->minute(30);
    
        $finish = $start->copy()->addHours(1)->addMinutes(30);
    
        for ($x = 0; $x <= 3; $x++) {
        
            DB::table('dance_events')->insert([
                'start' => $start,
                'finish' => $finish,
                'group_id' => rand(1, 12),
                'hall_id' => rand(1,4),
                'company_id' => FirstCompanySeeder::COMPANY_ID,
                'trainer_id' =>  null,
                'active' => true
            ]);
        
            $start = $start->addHours(3);
            $finish = $finish->addHours(3);
        }
        
    }
}
