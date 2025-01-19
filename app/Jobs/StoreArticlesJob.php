<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use Illuminate\Support\Carbon;

class StoreArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $articles;
    protected string $source;

    public function __construct(array $articles, string $source)
    {
        $this->articles = $articles;
        $this->source = $source;
    }

    public function handle()
    {
        foreach ($this->articles as $article) {
            $mappedArticle = $this->mapArticle($article);

            Article::updateOrCreate(
                ['url' => $mappedArticle['url']],
                $mappedArticle
            );
        }
    }


    private function mapArticle(array $article): array
    {
        if ($this->source === 'nytimes') {
            return [
                'title' => $article['title'],
                'author' => $article['byline'] ?? 'Unknown',
                'api_source' => $this->source,
                'source' => $article['source'] ?? 'Unknown',
                'category' => $article['section'] ?? 'General',
                'published_at' => Carbon::parse($article['published_date'])->format('Y-m-d H:i:s') ?? now(),
                'content' => $article['abstract'] ?? '',
                'url' => $article['url'],
                'image' => $article['media'][0]['media-metadata'][2]['url'] ?? 'empty.png',
            ];
        } elseif ($this->source === 'newsapi') {
            return [
                'title' => $article['title'],
                'author' => $article['author'] ?? 'Unknown',
                'api_source' => $this->source,
                'source' => $article['source']['name'] ?? 'Unknown',
                'category' => $article['category'] ?? 'General',
                'published_at' => Carbon::parse($article['publishedAt'])->format('Y-m-d H:i:s') ?? now(),
                'content' => $article['description'] ?? '',
                'url' => $article['url'],
                'image' => $article['urlToImage'] ?? 'empty.png',
            ];
        }

        return [];
    }
}
