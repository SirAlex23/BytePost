<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsApiService;
use App\Services\AiSummaryService;
use App\Models\Article;
use Illuminate\Support\Str;

class FetchLatestNews extends Command
{
    protected $signature   = 'bytepost:fetch-news {--category= : Categoría específica} {--no-ai : Importar sin IA}';
    protected $description = 'Importa las últimas noticias de NewsData.io a BytePost';

    protected array $blockedKeywords = [
        'queen', 'royal', 'raven', 'drunk driving', 'house fire',
        'law firm', 'pooh', 'census', 'peter obi', 'snowflake inc investors',
        'marriage', 'wedding', 'celebrity', 'actor', 'singer', 'movie',
        'football', 'soccer', 'basketball', 'cricket', 'tennis',
        'recipe', 'cooking', 'fashion', 'beauty', 'makeup',
        'horoscope', 'zodiac', 'lottery', 'weather forecast',
        'murder', 'crime', 'arrest', 'prison', 'shooting',
        'parliament', 'election', 'senator', 'congress',
        'hospital', 'disease', 'vaccine', 'cancer', 'diabetes',
        'blog posts to learn', 'shapiro', 'populist', 'law firm',
        'andhra', 'palantir lonsdale', 'tim cook built',
    ];
    
    public function handle(NewsApiService $newsService, AiSummaryService $aiService): void
    {
        $this->info('🔄 Iniciando importación de noticias...');

        $useAi    = !$this->option('no-ai');
        $category = $this->option('category');

        if ($useAi) {
            $this->info('🤖 Modo IA activado — generando artículos completos en español');
        }

        if ($category) {
            $articles = $newsService->fetchByCategory($category);
            $this->processArticles($articles, $aiService, $useAi, $category);
        } else {
            $articles = $newsService->fetchAllCategories();
            $this->processArticles($articles, $aiService, $useAi);
        }

        $this->info('✅ Importación completada.');
    }

    protected function processArticles(array $articles, AiSummaryService $aiService, bool $useAi, ?string $defaultCategory = null): void
    {
        $imported = 0;
        $skipped  = 0;
        $blocked  = 0;

        foreach ($articles as $item) {
            if (empty($item['title'])) {
                $skipped++;
                continue;
            }

            // Filtrar noticias no tecnológicas
            $titleLower = strtolower($item['title'] . ' ' . ($item['description'] ?? ''));
            $isBlocked  = false;
            foreach ($this->blockedKeywords as $keyword) {
                if (str_contains($titleLower, $keyword)) {
                    $isBlocked = true;
                    break;
                }
            }
            if ($isBlocked) {
                $blocked++;
                $this->line("  ✗ Bloqueado: " . Str::limit($item['title'], 60));
                continue;
            }

            $category = $defaultCategory ?? $item['_bytepost_category'] ?? 'tecnologia';
            $slug     = Str::slug($item['title']);

            if (Article::where('slug', $slug)->exists()) {
                $skipped++;
                continue;
            }

            $originalContent = $item['content'] ?? $item['description'] ?? $item['title'];
            $excerpt         = Str::limit($item['description'] ?? $item['title'], 200);
            $content         = $originalContent;
            $aiSummary       = '';

            // Generar contenido con IA
            if ($useAi && !empty($item['title'])) {
                $this->line("  🤖 Generando artículo: " . Str::limit($item['title'], 50));
                $generated = $aiService->generateArticle(
                    $item['title'],
                    $item['description'] ?? '',
                    $category
                );

                if (!empty($generated['content'])) {
                    $content   = $generated['content'];
                    $aiSummary = $generated['summary'];
                }

                // Pausa para no saturar la API de Groq
                sleep(2);
            }

            $wordCount   = str_word_count(strip_tags($content));
            $readingTime = max(1, ceil($wordCount / 200));

            Article::create([
                'title'            => $item['title'],
                'slug'             => $slug,
                'excerpt'          => $excerpt,
                'content'          => $content,
                'cover_image'      => $item['image_url'] ?? null,
                'category'         => $category,
                'tags'             => $item['keywords'] ?? [],
                'author_id'        => null,
                'status'           => 'published',
                'published_at'     => now(),
                'source'           => $item['source_id'] ?? 'newsdata.io',
                'source_url'       => $item['link'] ?? null,
                'ai_summary'       => $aiSummary,
                'reading_time'     => $readingTime,
                'views'            => 0,
                'featured'         => false,
                'language'         => 'es',
                'meta_description' => Str::limit($excerpt, 160),
                'published_at'     => null,
            ]);

            $imported++;
            $this->line("  ✓ Importado: " . Str::limit($item['title'], 60));
        }

        $this->info("📊 Importados: $imported | Bloqueados: $blocked | Duplicados: $skipped");
    }
}