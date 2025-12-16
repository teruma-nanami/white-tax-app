<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
  public function __construct(
    private readonly ChatbotService $chatbotService
  ) {}

  /**
   * チャット画面表示
   */
  public function index()
  {
    return view('chatbot.index');
  }

  /**
   * 質問送信（AJAX）
   */
  public function message(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'question' => ['required', 'string', 'max:2000'],
    ]);

    try {
      $answer = $this->chatbotService->ask($validated['question']);

      return response()->json([
        'answer' => $answer,
      ]);
    } catch (\Throwable $e) {
      // ログだけ仕込んでおくと便利
      \Log::error('Chatbot API error', [
        'error' => $e->getMessage(),
      ]);

      return response()->json([
        'answer' => '現在、回答を取得できません。しばらく時間をおいて再度お試しください。',
      ], 500);
    }
  }
}