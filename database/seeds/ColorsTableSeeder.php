<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    private $dance_groups = [
        ['PowderBlue', '#B0E0E6'],
        ['SkyBlue','#87CEEB'],
        ['Lavender','#E6E6FA'],
        ['LightPink','#FFB6C1'],
        ['Salmon','#FA8072'],
        ['LightSalmon','#FFA07A'],
        ['Khaki','#F0E68C'],
        ['Gold','#FFD700'],
        ['LemonChiffon','#FFFACD'],
        ['Moccasin','#FFE4B5'],
        ['PeachPuff','#FFDAB9'],
        ['Lavender','#E6E6FA'],
        ['Wheat','#F5DEB3'],
        ['Cornsilk','#FFF8DC'],
        ['Honeydew','#F0FFF0'],
        ['Azure','#F0FFFF'],
        ['AntiqueWhite','#FAEBD7'],
        ['PaleGreen','#98FB98'],
        ['LightGreen','#90EE90']
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->dance_groups as $role){
            DB::table('colors')->insert([
                'name' => $role[0],
                'hex' => $role[1]
            ]);
        }
    }
}
