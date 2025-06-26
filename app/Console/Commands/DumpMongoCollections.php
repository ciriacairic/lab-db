<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Mongo\Review;
use App\Models\Mongo\Theme;

class DumpMongoCollections extends Command
{
    protected $signature = 'mongo:dump';
    protected $description = 'Dump MongoDB collections to JSON';

    public function handle()
    {
        $collections = [
            'reviews' => Review::all()->toArray(),
            'themes' => Theme::all()->toArray(),
        ];

        foreach ($collections as $name => $data) {
            File::put(storage_path("mongo/{$name}.json"), json_encode($data, JSON_PRETTY_PRINT));
            $this->info("Dumped {$name} collection to storage/mongo/{$name}.json");
        }
    }
}
