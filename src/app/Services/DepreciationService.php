<?php

namespace App\Services;

use App\Models\Ledger;
use App\Models\Category;
use App\Models\Entry;
use App\Models\TaxRule;
use Illuminate\Support\Collection;

class DepreciationService
{
  public function getDepreciationCandidates(Ledger $ledger, int $threshold = 110001): Collection
  {
    return $ledger->entries()
      ->with('category')
      ->whereHas('category', function ($query) {
        $query->where('default_type', 'Expense');
      })
      ->where('amount_inc_tax', '>=', $threshold)
      ->orderBy('transaction_date', 'desc')
      ->get();
  }
  /**
   * 減価償却費登録画面に必要なデータを準備
   */
  public function prepareCreate(Ledger $ledger): array
  {
    $year = $ledger->fiscal_year;

    // 経費カテゴリのみを候補として表示
    $categories = Category::where('default_type', 'Expense')
      ->orderBy('category_name')
      ->get();

    return [
      'ledger'     => $ledger,
      'year'       => $year,
      'categories' => $categories,
    ];
  }

  /**
   * 減価償却費として Entry を新規作成
   *
   * 実体は通常の経費 Entry。
   */
  public function storeDepreciationEntry(Ledger $ledger, int $userId, array $data): Entry
  {
        // カテゴリを取得（必ず経費系）
    /** @var \App\Models\Category $category */
    $category = Category::findOrFail($data['category_id']);

    // カテゴリのデフォルト税区分から TaxRule を引く想定
    // ※ TaxRule 側のキー名はプロジェクトに合わせて調整してください
    $taxRule = TaxRule::where('rule_key', $category->default_tax_category)->first();

    if (!$taxRule) {
      // プロジェクトによってはここを別のハンドリングにしてOK
      throw new \RuntimeException('適用できる税区分が見つかりません。TaxRule を確認してください。');
    }

    // 摘要：指定があれば「減価償却費（◯◯）」形式にする
    $baseLabel = '減価償却費';
    if (!empty($data['description'])) {
      $description = $baseLabel . '（' . $data['description'] . '）';
    } else {
      $description = $baseLabel;
    }

    return Entry::create([
      'user_id'      => $userId,
      'ledger_id'    => $ledger->id,
      'category_id'  => $category->id,
      'tax_rule_id'  => $taxRule->id,
      'transaction_date' => $data['transaction_date'],
      'amount_inc_tax'   => $data['amount_inc_tax'],
      'tax_category'     => $category->default_tax_category,
      'is_invoice_received' => false,
      'is_capitalized'      => false, // これは「償却費」なので資産側ではない
      'is_recurring'        => false,
      'partner_name'        => $data['partner_name'] ?? null,
      'description'         => $description,
    ]);
  }
}