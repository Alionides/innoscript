<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use App\Services\NewsAPIService;
//use App\Jobs\StoreArticlesJob;
//
//class FetchNewsOld extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'app:fetch-news';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Fetch news articles from external APIs and store them locally';
//
//    /**
//     * NewsAPIService instance.
//     */
//    protected $newsAPIService;
//
//    /**
//     * Create a new command instance.
//     */
//    public function __construct(NewsAPIService $newsAPIService)
//    {
//        parent::__construct();
//        $this->newsAPIService = $newsAPIService;
//    }
//
//    /**
//     * Execute the console command.
//     */
//    public function handle()
//    {
//        $this->info('Fetching news from NewsAPI...');
//
//        // Fetch articles using the NewsAPIService
//        $articles = $this->newsAPIService->fetchArticles();
//
//        if (!empty($articles)) {
//            // Dispatch the StoreArticlesJob to save articles in the database
//            StoreArticlesJob::dispatch($articles);
//            $this->info('News articles fetched and dispatched for storage.');
//        } else {
//            $this->warn('No articles found.');
//        }
//    }
//}
