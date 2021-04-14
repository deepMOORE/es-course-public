<?php declare(strict_types=1);

namespace App\Models;

use App\Observers\ElasticsearchObserver;

abstract class SearchModel extends BaseModel
{
    public static function bootSearchable(): void
    {
        if (config('services.elasticsearch.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function getSearchIndex(): string
    {
        return $this->getTable();
    }

    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
