<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdditionalCost;
use App\Models\Fishes;
use App\Models\Monthly_cost;

class UpdateAdditionalCost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cost:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('starting..');
        $fishes = Fishes::whereIn('status_id',[1,3])->get();

        foreach ($fishes as $fish) {
            // $this->info($fish->id);
            $addtionalCost = AdditionalCost::where('fish_id',$fish->id)->whereMonth('created_at',date('m'))->whereYear('created_at', date('Y'))->count();
           
            if ($addtionalCost == 0) {
                $monthlyCost = Monthly_cost::where('size_id',$fish->size_id)->first();
                AdditionalCost::create([
                    'fish_id' => $fish->id,
                    'nominal' =>  $monthlyCost->cost
                ]);

                $this->info('created #'.$fish->id);
            }else{
                $this->info('data ikan #'.$fish->id.' sudah ada.');
            }
        }

        $this->info('finished..');

    }
}
