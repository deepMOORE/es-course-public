<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class IndexByElasticsearch extends Command
{
    protected $signature = 'elasticsearch:index';

    protected $description = 'Indexing data by elasticsearch';

    private Client $client;

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    public function handle()
    {
        $this->info('Started');

        foreach (Article::cursor() as $article)
        {
            $this->client->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);
        }

        $this->info('Done');
    }
}
