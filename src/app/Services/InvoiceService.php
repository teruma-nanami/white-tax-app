<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\Ledger;

class InvoiceService
{
  /**
   * インボイス登録済みユーザーの
   * 当年度インボイス対象取引を取得＆集計
   */
  public function getInvoiceEntriesForCurrentYear(int $userId): array
  {
    $year = now()->year;

    // 当年度 Ledger を取得（なければ 404）
    $ledger = Ledger::where('user_id', $userId)
      ->where('fiscal_year', $year)
      ->firstOrFail();

    // インボイス対象：
    // → invoice_number が入っている取引のみ
    $entries = Entry::with('category')
      ->where('user_id', $userId)
      ->where('ledger_id', $ledger->id)
      ->whereNotNull('invoice_number')
      ->where('invoice_number', '!=', '')
      ->orderBy('transaction_date', 'desc')
      ->orderBy('id', 'desc')
      ->get();

    $invoiceIncome  = 0;
    $invoiceExpense = 0;

    foreach ($entries as $entry) {
      $type = $entry->category->default_type ?? null;

      // amount_inc_tax は decimal だけど、ここでは int として扱う
      $amount = (int) $entry->amount_inc_tax;

      if ($type === 'Revenue') {
        $invoiceIncome += $amount;
      } elseif ($type === 'Expense') {
        $invoiceExpense += $amount;
      }
    }

    return [
      'ledger'  => $ledger,
      'year'    => $year,
      'entries' => $entries,
      'summary' => [
        'invoice_income'  => $invoiceIncome,
        'invoice_expense' => $invoiceExpense,
        'invoice_balance' => $invoiceIncome - $invoiceExpense,
      ],
    ];
  }
}