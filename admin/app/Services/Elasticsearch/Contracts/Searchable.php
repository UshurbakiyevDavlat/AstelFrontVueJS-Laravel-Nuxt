<?php

namespace App\Services\Elasticsearch\Contracts;

interface Searchable
{
    public function getElasticKey() : string;

    public function toElastic() : array;
    public function prepareToIndex() : array;

    public function shouldIndex() : bool;

    public static function findByElasticKey(string $key);
    // Visualization
    public function getElasticTitle() : string;
    public function getElasticDescription() : string;
    // Link
    public function getElasticTemplate();
    public function getElasticSlug();

}
