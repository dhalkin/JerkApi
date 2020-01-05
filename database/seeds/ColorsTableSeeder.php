<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    private $groups = [
        ['blue', '#007bff', 'RGBA(0,123,255,0.25)'],
        ['indigo','#6610f2', 'RGBA(102,16,242,0.25)'],
        ['purple','#6f42c1', 'RGBA(111,66,193,0.25)'],
        ['pink','#e83e8c', 'RGBA(232,62,140,0.25)'],
        ['red','#dc3545', 'RGBA(220,53,69,0.25)'],
        ['orange','#fd7e14', 'RGBA(253,126,20,0.25)'],
        ['yellow','#ffc107', 'RGBA(255,193,7,0.25)'],
        ['green','#28a745', 'RGBA(40,167,69,0.25)'],
        ['teal','#20c997', 'RGBA(32,201,151,0.25)'],
        ['cyan','#17a2b8', 'RGBA(23,162,184,0.25)'],
        ['gray','#6c757d', 'RGBA(108,117,125,0.25)'],
        ['event-azure','#51BCDA', 'rgba(81, 188, 218, 0.2)'],
        ['event-orange','#FBC658', 'rgba(251, 198, 88, 0.2)'],
        ['event-green','#6BD098', 'rgba(107, 208, 152, 0.2)']
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->groups as $role){
            DB::table('colors')->insert([
                'name' => $role[0],
                'hex' => $role[1],
                'rgba' => $role[2]
            ]);
        }
    }
}
