<?php

namespace App\Services;

use App\Models\Ledger;
use App\Models\Entry;
use App\Models\UserProfiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class EntryQueryService
{
  /**
   * 当年度の取引一覧を取得（Ledgerがなければ作成）
   */
  public function getEntriesForCurrentYear(int $userId): array
  {
    // 当年度（暦年）
    $year = now()->year;

    // Ledger を保証
    $ledger = Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'draft',
      ]
    );

    // Entry 一覧取得
    $entries = Entry::with('category')
      ->where('ledger_id', $ledger->id)
      ->orderByDesc('transaction_date')
      ->orderByDesc('id')
      ->get();

    return [
      'year'    => $year,
      'ledger'  => $ledger,
      'entries' => $entries,
    ];
  }

  /**
   * 取引編集用データ取得
   */
  public function getEntryForEdit(int $entryId, int $userId): array
  {
    // Entry 取得（ユーザー紐づき保証）
    $entry = Entry::where('id', $entryId)
      ->where('user_id', $userId)
      ->firstOrFail();

    // Ledger 取得
    $ledger = Ledger::findOrFail($entry->ledger_id);

    // UserProfile 取得（無い場合は null）
    $profile = UserProfiles::where('user_id', $userId)->first();

    // インボイス有効判定
    $isInvoiceEnabled = $profile?->invoice_enabled ?? false;

    return [
      'entry'            => $entry,
      'ledger'           => $ledger,
      'isInvoiceEnabled' => $isInvoiceEnabled,
    ];
  }
  /**
   * 取引登録画面用データ
   */
  public function prepareCreateData(int $userId): array
  {
    $year = now()->year;

    $ledger = Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'draft',
      ]
    );

    $profile = UserProfiles::where('user_id', $userId)->first();


    return [
      'ledger' => $ledger,
      'isInvoiceEnabled' => $profile?->invoice_enabled ?? false,
    ];
  }

  /**
   * 取引登録処理
   */
  public function createEntry(int $userId, array $data): Entry
  {
    $year = now()->year;

    $ledger = Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'Draft',
      ]
    );

    return Entry::create([
      'user_id'              => $userId,
      'ledger_id'            => $ledger->id,
      'category_id'          => $data['category_id'],
      'tax_rule_id'          => $data['tax_rule_id'],
      'transaction_date'     => $data['transaction_date'],
      'amount_inc_tax'       => $data['amount_inc_tax'],
      'tax_category'         => $data['tax_category'],
      'description'          => $data['description'] ?? null,
      'partner_name'         => $data['partner_name'] ?? null,
      'is_invoice_received'  => $data['is_invoice_received'] ?? false,
      'is_capitalized'       => $data['is_capitalized'] ?? false,
      'is_recurring'         => $data['is_recurring'] ?? false,
    ]);
  }

  /**
   * カテゴリー別集計（当年度・支出のみ）
   */
  public function getCategorySummaryForCurrentYear(int $userId): array
  {
    $year = now()->year;

    // Ledger 保証
    $ledger = Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'Draft',
      ]
    );

    // カテゴリー別集計（支出のみ）
    $summaries = Entry::query()
      ->select([
        'categories.id as category_id',
        'categories.category_name',
        DB::raw('SUM(entries.amount_inc_tax) as total'),
        DB::raw('COUNT(entries.id) as count'),
      ])
      ->join('categories', 'entries.category_id', '=', 'categories.id')
      ->where('entries.ledger_id', $ledger->id)
      ->where('categories.default_type', 'Expense')
      ->groupBy('categories.id', 'categories.category_name')
      ->orderByDesc('total')
      ->get();

    return [
      'year' => $year,
      'ledger' => $ledger,
      'categorySummaries' => $summaries,
    ];
  }

  /**
   * 減価償却対象候補一覧（当年度・経費・閾値以上）
   */
  public function getCapitalizedCandidatesForCurrentYear(
    int $userId,
    int $threshold = 110001
  ): array {
    $year = now()->year;

    // Ledger 保証
    $ledger = Ledger::firstOrCreate(
      [
        'user_id'     => $userId,
        'fiscal_year' => $year,
      ],
      [
        'status' => 'Draft',
      ]
    );

    // 減価償却候補抽出
    $entries = Entry::query()
      ->with('category')
      ->where('ledger_id', $ledger->id)
      ->whereHas('category', function ($query) {
        $query->where('default_type', 'Expense');
      })
      ->where('amount_inc_tax', '>=', $threshold)
      ->orderByDesc('transaction_date')
      ->get();

    return [
      'year'      => $year,
      'threshold' => $threshold,
      'entries'   => $entries,
    ];
  }
}