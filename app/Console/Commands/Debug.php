<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storeUser = User::firstWhere('store_name', 'nanocity');
        dd($storeUser->logo_url);

        // $settings = Setting::where('key', 'logo')->pluck('value')->toArray();
        // dd($settings);
    }
}
