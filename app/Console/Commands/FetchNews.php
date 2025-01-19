<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NytimesService;
use App\Services\NewsAPIService;
use App\Jobs\StoreArticlesJob;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news articles from various sources and store them.';

    protected NytimesService $nytimesService;
    protected NewsAPIService $newsApiService;

    /**
     * Create a new command instance.
     */
    public function __construct(NytimesService $nytimesService, NewsAPIService $newsApiService)
    {
        parent::__construct();
        $this->nytimesService = $nytimesService;
        $this->newsApiService = $newsApiService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching articles from New York Times...');
        $nytimesArticles = $this->nytimesService->fetchTopArticles();
        if (!empty($nytimesArticles)) {
            StoreArticlesJob::dispatch($nytimesArticles, 'nytimes');
            $this->info('New York Times articles queued for storage.');
        } else {
            $this->warn('No articles fetched from New York Times.');
        }

        $this->info('Fetching articles from NewsAPI...');
        $newsApiArticles = $this->newsApiService->fetchTopHeadlines();
        if (!empty($newsApiArticles)) {
            StoreArticlesJob::dispatch($newsApiArticles, 'newsapi');
            $this->info('NewsAPI articles queued for storage.');
        } else {
            $this->warn('No articles fetched from NewsAPI.');
        }
    }
}
