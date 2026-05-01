<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSummaryService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model   = 'llama3-8b-8192';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
    }

    public function generateArticle(string $title, string $excerpt, string $category): array
    {
        $prompt = "IMPORTANTE: Responde ÚNICAMENTE en español castellano. No uses inglés bajo ninguna circunstancia.

Eres un periodista tech profesional que escribe para BytePost...

Basándote en esta noticia:
TÍTULO: {$title}
RESUMEN: {$excerpt}
CATEGORÍA: {$category}

Escribe un artículo completo en español con estas reglas:
- Entre 300 y 500 palabras
- Tono profesional pero accesible
- Incluye contexto y análisis, no solo los hechos
- NO inventes datos específicos que no estén en el resumen
- NO uses markdown, solo texto plano con párrafos separados por saltos de línea
- Empieza directamente con el contenido, sin título

Responde SOLO con el artículo, nada más.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model'       => $this->model,
                'messages'    => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens'  => 1000,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content') ?? '';

                // Generar también un resumen corto
                $summary = $this->generateSummary($title, $content);

                return [
                    'content' => trim($content),
                    'summary' => $summary,
                ];
            }

            Log::error('Groq API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return ['content' => '', 'summary' => ''];

        } catch (\Exception $e) {
            Log::error('Groq failed: ' . $e->getMessage());
            return ['content' => '', 'summary' => ''];
        }
    }

    public function generateSummary(string $title, string $content): string
    {
        $prompt = "Resume este artículo en máximo 2 frases en español, de forma clara y directa. Solo el resumen, nada más.

TÍTULO: {$title}
CONTENIDO: " . substr($content, 0, 500);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(15)->post($this->baseUrl, [
                'model'       => $this->model,
                'messages'    => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.5,
                'max_tokens'  => 150,
            ]);

            if ($response->successful()) {
                return trim($response->json('choices.0.message.content') ?? '');
            }

            return '';

        } catch (\Exception $e) {
            return '';
        }
    }
}