<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends SearchModel
{
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
