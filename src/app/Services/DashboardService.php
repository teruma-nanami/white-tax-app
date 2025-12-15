<?php

namespace App\Services;

use App\Models\Entry;
use Carbon\Carbon;

class DashboardService
{
  /**
   * 指定ユーザーの年間収支を集計する
   */
  public function getAnnualSummaryForUser(int $userId): array
  {
    $currentYear = Carbon::now()->year;

    $entries = Entry::where('user_id', $userId)
      ->whereYear('transaction_date', $currentYear)
      ->get();

    $income = $entries
      ->where('amount_inc_tax', '>', 0)
      ->sum('amount_inc_tax');

    $expense = $entries
      ->where('amount_inc_tax', '<', 0)
      ->sum('amount_inc_tax');

    $expense = abs($expense);

    return [
      'income'  => $income ?? 0,
      'expense' => $expense ?? 0,
      'balance' => ($income ?? 0) - ($expense ?? 0),
    ];
  }
  public function getNotifications(): array
  {
    $notifications = [
      [
        'title' => 'サービス開始のお知らせ',
        'body' => '白色申告アプリをご利用いただきありがとうございます。',
        'published_at' => '2025-01-01',
      ],
      [
        'title' => 'アップデート予定のお知らせ',
        'body' => '今後、確定申告書PDF出力機能を追加予定です。',
        'published_at' => '2025-02-01',
      ],
    ];

    // 新しい順に並び替え
    usort($notifications, function ($a, $b) {
      return strtotime($b['published_at']) <=> strtotime($a['published_at']);
    });

    return $notifications;
  }
}