<?php

namespace App\Services\Elasticsearch;

use Elasticsearch\ClientBuilder;

use App\Services\Elasticsearch\Contracts\Searchable;
use App\Services\Elasticsearch\Http\Resources\SearchableResource;

class ElasticsearchService
{

    protected $client;
    protected $config;

    public function __construct()
    {
        $this->config = config('services.elasticsearch');
    }


    public function isDisabled() : bool
    {
        return !$this->isEnabled();
    }

    public function isEnabled() : bool
    {
        return $this->config['enabled'];
    }


    public function getSearchQuery(string $q) : array
    {
        $q = mb_strtolower(trim($q));

        return [
            'bool' => [
                'should' => [
                    [
                        'multi_match' => [
                            'fields' => ['data'],
                            'query' => $q,
                            'type' => 'phrase_prefix',
                            'slop' => 20,
                            'boost' => 1.2,
                        ],
                    ],
                    [
                        'fuzzy' => [
                            'data' => [
                                'value' => $q,
                                'max_expansions' => min(200, 40*strlen($q)),
                            ],
                        ],
                    ],
                ],
                'minimum_should_match' => 1,
            ]
        ];
    }

    public function search(string $q, $per_page = 20, $page = 1)
    {
        if ($this->isDisabled()) {
            return [];
        }
        $from = ($page - 1) * $per_page;
        $response = $this->getClient()->search([
            '_source' => [
                'class', 'key'
            ],
            'index' => $this->getIndexName(),
            'body' => [
                'query' => $this->getSearchQuery($q),
            ],
            'from' => $from,
            'size' => $per_page,
        ]);

        $hits = array_map(function($hit) {
            return new SearchableResource($hit['_source']['class']::findByElasticKey($hit['_source']['key']));
        }, $response['hits']['hits']);

        $total = $response['hits']['total']['value'];

        return [
            'current_page' => $page,
            'data' => $hits,
            'from' => $from,
            'last_page' => intval(ceil($total / $per_page)),
            'per_page' => $per_page,
            'to' => min($total, $from + $per_page),
            'total' => $total,
        ];
    }


    public function indexDocument(array $params)
    {
        $params['index'] = $this->getIndexName();
        return $this->getClient()->index($params);
    }

    public function updateDocument(array $params)
    {
        $params['index'] = $this->getIndexName();
        return $this->getClient()->update($params);
    }

    public function dropDocument(array $params) : bool
    {
        try {
            return $this->getClient()->delete($params);
        } catch(\Exception $e) {
            //
        }
        return false;
    }



    public function createIndex()
    {
        return $this->getClient()->indices()->create($this->getParams());
    }

    public function dropIndex()
    {
        return $this->getClient()->indices()->delete([
            'index' => $this->getIndexName(),
        ]);
    }

    public function seedDocuments(array $params)
    {
        $params['index'] = $this->getIndexName();
        return $this->getClient()->bulk($params);
    }



    protected function getParams() : array
    {
        return [
            'index' => $this->getIndexName(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    'properties' => []
                ],
            ],
        ];
    }


    protected function getClient()
    {
        if (!$this->client) {
            $this->client = ClientBuilder::create()->setHosts($this->config['hosts'])->build();
        }
        return $this->client;
    }


    public function getIndexName() : string
    {
        return $this->config['index_name'];
    }

    public function getSearchableClasses() : array
    {
        $files = glob(base_path('app/Models') . '/*.php');
        $searchable_classes = [];

        foreach($files as $file) {
            $class = '\\App\\Models\\' . basename($file, '.php');
            $instance = new $class;
            if ($instance instanceof Searchable) {
                $searchable_classes[] = $class;
            }
        }

        return $searchable_classes;
    }
}
