<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticsearchRepository
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $query = ''): array
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->extractIds($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Article();

        return $this->client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);
    }

    private function extractIds(array $items): array
    {
        return Arr::pluck($items['hits']['hits'], '_id');
    }
}
