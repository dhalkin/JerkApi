<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ORM\Model\Color;

class PushColorsIntoQueueCommand extends Command
{
    
    protected $color;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:pushcolors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Some command for exercising';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Color $color)
    {
        parent::__construct();
        $this->color = $color;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Get all Colors');
        $colors = $this->color->all();
        foreach ($colors as $color){
            $this->info($color->name);
            
        }
        
        
    }
}
