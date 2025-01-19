<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsAPIService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('NEWSAPI_KEY');
        $this->baseUrl = 'https://newsapi.org/v2';
    }

    /**
     * Fetch top headlines from NewsAPI.
     *
     * @return array
     */
    public function fetchTopHeadlines(): array
    {
        $endpoint = "{$this->baseUrl}/top-headlines";

        try {
            $response = Http::get($endpoint, [
                'apiKey' => $this->apiKey,
                'country' => 'us',
                'category' => 'general',
            ]);

            if ($response->successful()) {
                return $response->json()['articles'] ?? [];
            } else {
                throw new \Exception("Failed to fetch articles: {$response->body()}");
            }
        } catch (\Exception $e) {
            Log::error("NewsAPI Error: {$e->getMessage()}");
            return [];
        }
    }
}
