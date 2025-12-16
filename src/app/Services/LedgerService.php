<?php

namespace App\Services;

use App\Models\Ledger;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class LedgerService
{
  /**
   * 現在の会計年度 Ledger を取得（なければ Draft で作成）
   */
  public function getCurrentLedger(int $userId): Ledger
  {
    $year = now()->year;

    return Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status'    => 'Draft',
        'locked_at' => null,
      ]
    );
  }

  /**
   * Ledger をロック状態にする
   *
   * @throws RuntimeException すでにロック済みの場合
   */
  public function lockLedger(Ledger $ledger): void
  {
    // すでにロック済みなら例外
    if ($ledger->status === 'Locked' || $ledger->locked_at !== null) {
      throw new RuntimeException('この会計年度はすでにロックされています。');
    }

    $ledger->status    = 'Locked';
    $ledger->locked_at = now();
    $ledger->save();
  }
}