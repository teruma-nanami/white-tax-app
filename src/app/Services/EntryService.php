<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Ledger;
use App\Models\Entry;
use App\Models\Category;
use App\Models\TaxRule;

class EntryService
{
  public function getEntryList(): array
  {
    $user = Auth::user();
    $year = now()->year;

    $ledger = Ledger::firstOrCreate(
      [
        'user_id' => $user->id,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'Draft',
      ]
    );

    $entries = Entry::where('ledger_id', $ledger->id)
      ->orderByDesc('transaction_date')
      ->get();

    return [
      'ledger' => $ledger,
      'entries' => $entries,
      'year' => $year,
    ];
  }

  /**
   * create画面用データ
   */
  public function getCreateData(): array
  {
    return [
      'categories' => Category::orderBy('category_name')->get(),
      'taxRules' => TaxRule::orderBy('id')->get(),
    ];
  }

  /**
   * 登録処理
   */
  public function storeEntry(array $data): void
  {
    $user = Auth::user();
    $year = now()->year;

    $ledger = Ledger::firstOrCreate(
      [
        'user_id' => $user->id,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'Draft',
      ]
    );

    Entry::create([
      'user_id' => $user->id,
      'ledger_id' => $ledger->id,
      'category_id' => $data['category_id'],
      'tax_rule_id' => $data['tax_rule_id'],
      'transaction_date' => $data['transaction_date'],
      'amount_inc_tax' => $data['amount_inc_tax'],
      'tax_category' => $data['tax_category'],
      'description' => $data['description'] ?? null,
      'partner_name' => $data['partner_name'] ?? null,
      'is_recurring' => isset($data['is_recurring']),
    ]);
  }
}