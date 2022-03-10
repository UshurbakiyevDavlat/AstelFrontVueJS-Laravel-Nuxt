<?php

namespace App\Services\Elasticsearch\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Elasticsearch\Facades\Elasticsearch;

class CreateIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates elasticsearch index';

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
        try {
            Elasticsearch::dropIndex();
            $this->info("Elasticsearch index deleted successfully!\n");
        } catch (\Exception $e) {

        }

        Elasticsearch::createIndex();

        $this->info("Elasticsearch index created successfully!\n");

        $searchable_classes = Elasticsearch::getSearchableClasses();

        foreach($searchable_classes as $model) {
            $params = ['body' => []];
            $chunk_size = 20;
    		$bar = $this->output->createProgressBar($model::count() / $chunk_size);

            $model::chunk($chunk_size, function($items) use($model, $bar) {

    			foreach($items as $item) {
                    if (!$item->shouldIndex()) {
                        continue;
                    }
    				$params['body'][] = [
    					'index' => [
    						'_index' => Elasticsearch::getIndexName(),
    						'_id' => $item->getElasticKey(),
    					],
    				];
    				$params['body'][] = $item->prepareToIndex();
    			}

    			if (count($params['body'])) {
    				Elasticsearch::seedDocuments($params);
    			}

    			$bar->advance();
    		});

    		$bar->finish();
            $this->info("\n{$model} migrated successfully!\n");
        }

        return 0;
    }
}
