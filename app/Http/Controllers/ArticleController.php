<?php

namespace App\Http\Controllers;

use App\Http\Models\ArticleModel;
use App\Http\Models\TagModel;
use App\Http\Response;
use App\Models\Article;
use App\Models\Tag;

class ArticleController extends Controller
{
    /**
     * Get all articles.
     */
    public function getAll()
    {
        $articles = Article::query()
            ->with('tags')
            ->get()
            ->map(function (Article $article) {
                return new ArticleModel(
                    $article->id,
                    $article->title,
                    $article->text,
                    $article->user_id,
                    $article->tags->map(
                        fn (Tag $tag) => new TagModel($tag->id, $tag->title)
                    )
                );
            });

        return Response::successView('articles', [
            'articles' => $articles
        ]);
    }
}
