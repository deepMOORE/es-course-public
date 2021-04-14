<?php declare(strict_types=1);

namespace App\Mappers;

use App\Http\Models\ArticleModel;
use App\Http\Models\TagModel;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Collection;

class ArticlesMapper
{
    /**
     * @param Collection|Article[] $articles
     * @return Collection|ArticleModel[]
     */
    public function map(Collection $articles): Collection
    {
        return $articles->map(fn (Article $article) => new ArticleModel(
            $article->id,
            $article->title,
            $article->text,
            $article->user_id,
            $article->tags->map(
                fn (Tag $tag) => new TagModel($tag->id, $tag->title)
            )
        ));
    }
}
