<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleSearchRequest;
use App\Http\Response;
use App\Mappers\ArticlesMapper;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\ElasticsearchRepository;
use Illuminate\Http\Request;
use JsonMapper;

class ArticleController extends Controller
{
    private ArticlesMapper $articlesMapper;
    private JsonMapper $jsonMapper;
    private ElasticsearchRepository $elasticsearchRepository;
    private ArticleRepository $articleRepository;

    public function __construct(
        ArticlesMapper $articlesMapper,
        JsonMapper $jsonMapper,
        ElasticsearchRepository $elasticsearchRepository,
        ArticleRepository $articleRepository
    ) {
        $this->articlesMapper = $articlesMapper;
        $this->jsonMapper = $jsonMapper;
        $this->elasticsearchRepository = $elasticsearchRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Get all articles.
     */
    public function getAll()
    {
        $models = $this->articleRepository->getAll();

        $articles = $this->articlesMapper->map($models);

        return Response::successView('articles', [
            'articles' => $articles
        ]);
    }

    /**
     * Search articles.
     */
    public function search(Request $request)
    {
        /** @var ArticleSearchRequest $body */
        $body = $this->jsonMapper->map((object)$request->all(), new ArticleSearchRequest());

        $ids = $this->elasticsearchRepository->search($body->searchTerm);

        $models = $this->articleRepository->getByIds($ids);

        $articles = $this->articlesMapper->map($models);

        return Response::successView('articles', [
            'articles' => $articles
        ]);
    }
}
