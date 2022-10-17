<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CoinsRenewalCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $incrementer = 1;
        $maxCoinAmount = 5;
        DB::table('users')
            ->where('coins', '>=', $maxCoinAmount - $incrementer)
            ->whereNot('id', 1)
            ->update(['coins' => $maxCoinAmount]);
        DB::table('users')
            ->where('coins', '<', $maxCoinAmount)
            ->increment('coins', $incrementer);
        return Command::SUCCESS;
    }
}
