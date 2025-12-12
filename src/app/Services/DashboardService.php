<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Ledger;
use App\Models\Entry;

class DashboardService
{
  /**
   * ダッシュボード表示用データ取得
   */
  public function getDashboardData(): array
  {
    $user = Auth::user();
    $currentYear = now()->year;

    $ledger = Ledger::where('user_id', $user->id)
      ->where('fiscal_year', $currentYear)
      ->first();

    return [
      'currentYear' => $currentYear,
      'ledger' => $ledger,
      'entryCount' => $ledger
        ? Entry::where('ledger_id', $ledger->id)->count()
        : 0,
      'filingStatus' => $ledger?->status ?? 'Draft',
    ];
  }
}