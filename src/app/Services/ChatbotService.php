<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ChatbotService
{
  /**
   * 質問をAIに投げて回答を取得
   */
  public function ask(string $question): string
  {
    $apiKey = config('services.openai.key');

    if (empty($apiKey)) {
      throw new RuntimeException('OpenAI APIキーが設定されていません。');
    }

    $response = Http::withToken($apiKey)
      ->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-4o-mini',
        'messages' => [
          [
            'role' => 'system',
            'content' => 'あなたは会計・税務アプリのサポートAIです。簡潔かつ分かりやすく回答してください。',
          ],
          [
            'role' => 'user',
            'content' => $question,
          ],
        ],
        'temperature' => 0.5,
      ]);

    if ($response->failed()) {
      throw new RuntimeException('AI APIの呼び出しに失敗しました。');
    }

    $data = $response->json();

    $answer = $data['choices'][0]['message']['content'] ?? null;

    if ($answer === null) {
      throw new RuntimeException('AI APIから有効な回答が取得できませんでした。');
    }

    return trim($answer);
  }
}