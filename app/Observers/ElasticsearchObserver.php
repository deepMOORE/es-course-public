<?php declare(strict_types=1);

namespace App\Observers;

use App\Models\SearchModel;
use Elasticsearch\Client;

class ElasticsearchObserver
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function saved(SearchModel $model): void
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function deleted(SearchModel $model): void
    {
        $this->client->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
