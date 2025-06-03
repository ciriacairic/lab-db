<?php

namespace App\Console\Commands;

use App\Models\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestMongoDBConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongo';

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
        $requests = [
            [
                'user_id' => 1,
                'game_name' => 'Crash Bandicoot',
                'game_description' => 'Descrição fake',
            ],
        ];

        foreach ($requests as $request) {
            Request::create($request);
        }

        $crash = Request::first();

        echo $crash;
    }
}
