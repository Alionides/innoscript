<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NytimesService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('NYTIMES_API_KEY');
        $this->baseUrl = 'https://api.nytimes.com/svc/mostpopular/v2';
    }

    public function fetchTopArticles(): array
    {
        $endpoint = "{$this->baseUrl}/emailed/7.json";

        try {
            $response = Http::get($endpoint, [
                'api-key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                return $response->json()['results'] ?? [];
            } else {
                throw new \Exception("Failed to fetch articles: {$response->body()}");
            }
        } catch (\Exception $e) {
            Log::error("New York Times API Error: {$e->getMessage()}");
            return [];
        }
    }
}
