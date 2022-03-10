<?php

namespace App\Services\Elasticsearch\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Elasticsearch\Facades\Elasticsearch;

class DropIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove elasticsearch index';

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
        Elasticsearch::dropIndex();

        $this->info("Elasticsearch index deleted successfully!");
        return 0;
    }
}
