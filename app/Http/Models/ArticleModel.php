<?php declare(strict_types=1);

namespace App\Http\Models;

use Illuminate\Support\Collection;

class ArticleModel
{
    public int $id;

    public string $title;

    public string $text;

    /**
     * @var Collection|TagModel[]
     */
    public Collection $tags;

    public int $userId;

    public function __construct(int $id, string $title, string $text, int $userId, Collection $tags)
    {
        $this->id = $id;
        $this->title = $title;
        $this->tags = $tags;
        $this->userId = $userId;
        $this->text = $text;
    }
}
