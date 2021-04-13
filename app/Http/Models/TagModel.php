<?php declare(strict_types=1);

namespace App\Http\Models;

class TagModel
{
    public int $id;

    public string $title;

    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
