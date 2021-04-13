<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    use InteractsWithConsole;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $startTime = microtime(true);

        $this->log('Starting generation');

        $this->log('Generate users');
        $users = $this->createUsers();

        $this->log('Generate articles');
        $articles = $this->createArticles($users);

        $this->log('Generate tags');
        $tags = $this->createTags($articles, $users);

        $this->log('Generation completed in: ' . round(microtime(true) - $startTime, 2));
    }

    private function createTags(Collection $articles, Collection $users): Collection
    {
        $tags = new Collection();

        foreach ($articles as $article) {
            $tags->push(...Tag::factory(random_int(5, 10))->make([
                'user_id' => $users->random()->id,
                'article_id' => $article->id
            ])->all());
        }

        Tag::insert($tags->toArray());

        return Tag::query()->get();
    }

    private function createArticles(Collection $users): Collection
    {
        $articles = new Collection();

        foreach ($users as $user) {
            $articles->push(...Article::factory(random_int(6, 12))->make([
                'user_id' => $user->id
            ])->all());
        }

        Article::insert($articles->toArray());

        return Article::query()->get();
    }

    private function createUsers(): Collection
    {
        User::factory(10)->create();

        return User::query()->get();
    }

    private function log(string $message): void
    {
        $this->command->info($message);
    }
}
