<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://newsdata.io/api/1/news';

    protected array $categoryKeywords = [
        'inteligencia-artificial' => [
            'q' => 'artificial intelligence',
        ],
        'ciberseguridad' => [
            'q' => 'cybersecurity',
        ],
        'tecnologia' => [
            'q' => 'technology',
        ],
        'herramientas-dev' => [
            'q' => 'programming developer',
        ],
        'alertas-seguridad' => [
            'q' => 'security breach vulnerability',
        ],
    ];

    public function __construct()
    {
        $this->apiKey = env('NEWSDATA_API_KEY');
    }

    public function fetchByCategory(string $category): array
    {
        if (!isset($this->categoryKeywords[$category])) {
            return [];
        }

        $params = $this->categoryKeywords[$category];

        try {
            $response = Http::timeout(15)->get($this->baseUrl, [
                'apikey'   => $this->apiKey,
                'q'        => $params['q'],
                'language' => 'en',
                'size'     => 10,
                'category' => 'technology',
            ]);

            if ($response->successful()) {
                return $response->json('results') ?? [];
            }

            Log::error('NewsData API error', [
                'status'   => $response->status(),
                'category' => $category,
                'body'     => $response->body(),
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('NewsData fetch failed: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchAllCategories(): array
    {
        $all = [];
        foreach (array_keys($this->categoryKeywords) as $category) {
            $this->info ?? null;
            $articles = $this->fetchByCategory($category);
            foreach ($articles as $article) {
                $article['_bytepost_category'] = $category;
                $all[] = $article;
            }
            sleep(1);
        }
        return $all;
    }
}