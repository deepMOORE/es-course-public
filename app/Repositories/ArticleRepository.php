<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Collection;

class ArticleRepository
{
    public function getAll(): Collection
    {
        return Article::query()
            ->with('tags')
            ->get();
    }

    public function getByIds(array $ids): Collection
    {
        return Article::query()
            ->whereIntegerInRaw('id', $ids)
            ->with('tags')
            ->get();
    }
}
