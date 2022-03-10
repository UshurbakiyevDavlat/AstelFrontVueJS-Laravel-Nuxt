<?php

namespace App\Services\Elasticsearch\Concerns;

use App\Services\Elasticsearch\Facades\Elasticsearch;
use App\Common\Contracts\Publishable;
use App\Common\Contracts\Sluggable;

trait Searchable
{

    public function prepareToIndex() : array
    {
        return [
            'data' => implodeToString($this->toElastic()),
            'class' => static::class,
            'key' => $this->getKey(),
        ];
    }

    public static function findByElasticKey(string $key)
    {
        return static::find($key);
    }


    public function getElasticTemplate()
    {
        return null;
    }

    public function getElasticSlug()
    {
        if ($this instanceof Sluggable) {
            return $this->slug;
        }

        return $this->getKey();
    }


    public static function bootSearchable()
    {
        if (Elasticsearch::isDisabled()) {
            return;
        }

        static::created(function ($item) {
            if ($item->shouldIndex()) {
                $item->indexItem();
            }
        });

        static::updated(function ($item) {
            if ($item->shouldIndex()) {
                try {
                    $item->updateItem();
                } catch (\Exception $e) {
                    $item->indexItem();
                }
            } else {
                try {
                    $item->removeItem();
                } catch (\Exception $e) {
                    //
                }
            }
        });

        static::deleted(function ($item) {
            $item->removeItem();
        });
    }

    public function shouldIndex() : bool
    {
        if ($this instanceof Publishable) {
            return $this->isActive();
        }
        return true;
    }

    private function indexItem()
    {
        return Elasticsearch::indexDocument([
            'id' => $this->getElasticKey(),
            'body' => $this->prepareToIndex(),
        ]);
    }

    private function updateItem()
    {
        return Elasticsearch::updateDocument([
            'id' => $this->getElasticKey(),
            'body' => $this->prepareToIndex(),
        ]);
    }

    private function removeItem()
    {
        return Elasticsearch::dropDocument([
            'id' => $this->getElasticKey(),
        ]);
    }

    public function getElasticKey() : string
    {
        return strtolower(class_basename(static::class) . '_' . $this->getKey());
    }

}
