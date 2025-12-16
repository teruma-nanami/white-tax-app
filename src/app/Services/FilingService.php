<?php

namespace App\Services;

use App\Models\Ledger;
use Illuminate\Support\Collection;
use App\Models\Entry;
use App\Models\TaxFilingData;

class FilingService
{
  /**
   * ユーザーに紐づく確定申告年度（Ledger）一覧を取得
   *
   * @param  int  $userId
   * @return \Illuminate\Support\Collection<Ledger>
   */
  public function getLedgersForUser(int $userId): Collection
  {
    return Ledger::query()
      ->where('user_id', $userId)
      ->orderByDesc('fiscal_year')   // migration のカラム名に合わせている
      ->get();
  }
  /**
   * 指定 Ledger の年間収支サマリーと仕訳一覧を取得
   *
   * @param  \App\Models\Ledger  $ledger
   * @return array{
   *   year:int,
   *   summary: array{income:int, expense:int, balance:int},
   *   entries: \Illuminate\Support\Collection<\App\Models\Entry>
   * }
   */
  public function getAnnualSummary(Ledger $ledger): array
  {
    // この Ledger に紐づく仕訳を取得（カテゴリも一緒に読み込む）
    $entries = Entry::query()
      ->with('category')
      ->where('ledger_id', $ledger->id)
      ->where('user_id', $ledger->user_id)
      ->orderBy('transaction_date')
      ->orderBy('id')
      ->get();

    // カテゴリの default_type で収入 / 支出を判定
    // 収入：default_type = 'Revenue'
    // 支出：default_type = 'Expense'
    $income = (int) $entries
      ->filter(fn(Entry $e) => optional($e->category)->default_type === 'Revenue')
      ->sum('amount_inc_tax');

    $rawExpense = (int) $entries
      ->filter(fn(Entry $e) => optional($e->category)->default_type === 'Expense')
      ->sum('amount_inc_tax');

    // 支出はプラス表示にそろえたいので絶対値を使う
    $expense = abs($rawExpense);

    $summary = [
      'income'  => $income,
      'expense' => $expense,
      'balance' => $income - $expense,
    ];

    return [
      'year'     => $ledger->fiscal_year,
      'summary'  => $summary,
      'entries'  => $entries,
    ];
  }
  /**
   * 控除入力フォーム表示用データ取得
   *
   * @return \App\Models\TaxFilingData|null
   */
  public function prepareDeductionForm(Ledger $ledger): ?TaxFilingData
  {
    return TaxFilingData::query()
      ->where('user_id', $ledger->user_id)
      ->where('ledger_id', $ledger->id)
      ->first();
  }

  /**
   * 控除データ保存（新規 or 更新）
   */
  public function storeDeductionData(Ledger $ledger, int $userId, array $data): TaxFilingData
  {
    return TaxFilingData::updateOrCreate(
      [
        'user_id'   => $userId,
        'ledger_id' => $ledger->id,
      ],
      [
        // 給与関連
        'salary_income'                      => $data['salary_income'] ?? null,
        'salary_withholding_tax'             => $data['salary_withholding_tax'] ?? null,
        'salary_social_insurance_paid'       => $data['salary_social_insurance_paid'] ?? null,
        'salary_life_insurance_ded'          => $data['salary_life_insurance_ded'] ?? null,
        'salary_earthquake_insurance_ded'    => $data['salary_earthquake_insurance_ded'] ?? null,
        'salary_dependents_count'            => $data['salary_dependents_count'] ?? null,
        'salary_spouse_ded_applied'          => !empty($data['salary_spouse_ded_applied']),
        'salary_commute_allowance_non_taxable' => $data['salary_commute_allowance_non_taxable'] ?? null,
        'salary_other_deductions'            => $data['salary_other_deductions'] ?? null,

        // 所得控除
        'life_insurance_general'             => $data['life_insurance_general'] ?? null,
        'life_insurance_medical'             => $data['life_insurance_medical'] ?? null,
        'life_insurance_pension'             => $data['life_insurance_pension'] ?? null,
        'social_insurance_ded'               => $data['social_insurance_ded'] ?? null,
        'medical_expense_ded'                => $data['medical_expense_ded'] ?? null,
        'donation_ded'                       => $data['donation_ded'] ?? null,
        'spouse_deduction_applied'           => !empty($data['spouse_deduction_applied']),
        'dependent_count'                    => $data['dependent_count'] ?? null,
        'small_enterprise_mutual_aid'        => $data['small_enterprise_mutual_aid'] ?? null,
        'ideco_contributions'                => $data['ideco_contributions'] ?? null,

        // 住宅ローン + その他
        'home_loan_year_end_balance'         => $data['home_loan_year_end_balance'] ?? null,
        'home_loan_deduction_amount'         => $data['home_loan_deduction_amount'] ?? null,
        'home_loan_type'                     => $data['home_loan_type'] ?? null,
        'home_loan_year_number'              => $data['home_loan_year_number'] ?? null,
        'misc_deductions'                    => $data['misc_deductions'] ?? null,
      ]
    );
  }
  /**
   * 控除編集用データ取得
   *
   * 指定 Ledger に紐づく TaxFilingData が存在しない場合は 404 相当の例外を投げる
   */
  public function getDeductionDataForEdit(Ledger $ledger): TaxFilingData
  {
    return TaxFilingData::query()
      ->where('user_id', $ledger->user_id)
      ->where('ledger_id', $ledger->id)
      ->firstOrFail();
  }

  /**
   * 控除データの更新
   */
  public function updateDeductionData(Ledger $ledger, int $userId, array $data): TaxFilingData
  {
    $taxFilingData = TaxFilingData::query()
      ->where('user_id', $userId)
      ->where('ledger_id', $ledger->id)
      ->firstOrFail();

    $taxFilingData->fill([
      // 給与関連
      'salary_income'                      => $data['salary_income'] ?? null,
      'salary_withholding_tax'             => $data['salary_withholding_tax'] ?? null,
      'salary_social_insurance_paid'       => $data['salary_social_insurance_paid'] ?? null,
      'salary_life_insurance_ded'          => $data['salary_life_insurance_ded'] ?? null,
      'salary_earthquake_insurance_ded'    => $data['salary_earthquake_insurance_ded'] ?? null,
      'salary_dependents_count'            => $data['salary_dependents_count'] ?? null,
      'salary_spouse_ded_applied'          => !empty($data['salary_spouse_ded_applied']),
      'salary_commute_allowance_non_taxable' => $data['salary_commute_allowance_non_taxable'] ?? null,
      'salary_other_deductions'            => $data['salary_other_deductions'] ?? null,

      // 所得控除
      'life_insurance_general'             => $data['life_insurance_general'] ?? null,
      'life_insurance_medical'             => $data['life_insurance_medical'] ?? null,
      'life_insurance_pension'             => $data['life_insurance_pension'] ?? null,
      'social_insurance_ded'               => $data['social_insurance_ded'] ?? null,
      'medical_expense_ded'                => $data['medical_expense_ded'] ?? null,
      'donation_ded'                       => $data['donation_ded'] ?? null,
      'spouse_deduction_applied'           => !empty($data['spouse_deduction_applied']),
      'dependent_count'                    => $data['dependent_count'] ?? null,
      'small_enterprise_mutual_aid'        => $data['small_enterprise_mutual_aid'] ?? null,
      'ideco_contributions'                => $data['ideco_contributions'] ?? null,

      // 住宅ローン + その他
      'home_loan_year_end_balance'         => $data['home_loan_year_end_balance'] ?? null,
      'home_loan_deduction_amount'         => $data['home_loan_deduction_amount'] ?? null,
      'home_loan_type'                     => $data['home_loan_type'] ?? null,
      'home_loan_year_number'              => $data['home_loan_year_number'] ?? null,
      'misc_deductions'                    => $data['misc_deductions'] ?? null,
    ]);

    $taxFilingData->save();

    return $taxFilingData;
  }
  /**
   * 確定申告書B + 収支決算書 プレビュー用データ構築
   */
  public function buildTaxReturnPreview(Ledger $ledger): array
  {
    // -------- 1. 収支決算書（収入 / 経費 / 差引所得） --------

    // 関連する仕訳をカテゴリ付きで取得
    $entries = $ledger->entries()->with('category')->get();

    // 収入合計（Category.default_type = 'Revenue'）
    $totalIncome = (int) $entries
      ->filter(fn($entry) => optional($entry->category)->default_type === 'Revenue')
      ->sum('amount_inc_tax');

    // 経費合計（Category.default_type = 'Expense'）
    $totalExpense = (int) $entries
      ->filter(fn($entry) => optional($entry->category)->default_type === 'Expense')
      ->sum('amount_inc_tax');

    $netIncome = $totalIncome - $totalExpense;

    // 経費の内訳（カテゴリ別）
    $expenseGroups = $entries
      ->filter(fn($entry) => optional($entry->category)->default_type === 'Expense')
      ->groupBy('category_id');

    $expenseBreakdown = $expenseGroups
      ->map(function ($group) {
        $categoryName = optional($group->first()->category)->category_name ?? '不明な科目';
        $amount       = (int) $group->sum('amount_inc_tax');

        return [
          'category' => $categoryName,
          'amount'   => $amount,
        ];
      })
      ->values()
      ->all();

    $incomeStatement = [
      'total_income'      => $totalIncome,
      'total_expense'     => $totalExpense,
      'net_income'        => $netIncome,
      'expense_breakdown' => $expenseBreakdown,
    ];

        // -------- 2. TaxFilingData から確定申告書B 表示用データ --------

    /** @var TaxFilingData|null $taxData */
    $taxData = $ledger->taxFilingData;

    // 給与所得（TaxFilingData に入っていない場合は null）
    $salaryIncome = $taxData?->salary_income;

    // 事業所得 = 収支決算書の差引所得（マイナスでもそのまま保持）
    $businessIncome = $netIncome;

    // 総所得金額
    $totalIncomeForTax = (int) (($salaryIncome ?? 0) + max($businessIncome, 0));

    // 所得控除合計（数値項目だけざっくり合計）
    $incomeDeductions = 0;

    if ($taxData) {
      $incomeDeductions = (int) (
        // 給与由来控除系
        ($taxData->salary_social_insurance_paid ?? 0)
        + ($taxData->salary_life_insurance_ded ?? 0)
        + ($taxData->salary_earthquake_insurance_ded ?? 0)
        + ($taxData->salary_other_deductions ?? 0)

        // 所得控除・保険料・医療・寄附
        + ($taxData->life_insurance_general ?? 0)
        + ($taxData->life_insurance_medical ?? 0)
        + ($taxData->life_insurance_pension ?? 0)
        + ($taxData->social_insurance_ded ?? 0)
        + ($taxData->medical_expense_ded ?? 0)
        + ($taxData->donation_ded ?? 0)
        + ($taxData->small_enterprise_mutual_aid ?? 0)
        + ($taxData->ideco_contributions ?? 0)

        // 住宅ローン控除額 + その他
        + ($taxData->home_loan_deduction_amount ?? 0)
        + ($taxData->misc_deductions ?? 0)
      );
    }

    $taxableIncome = max($totalIncomeForTax - $incomeDeductions, 0);

    // 税額は今回は「計算しない」（プレビューのみ）
    $taxReturn = [
      'salary_income'    => $salaryIncome,
      'business_income'  => $businessIncome ?: null,
      'total_income'     => $totalIncomeForTax,
      'income_deductions' => $incomeDeductions,
      'taxable_income'   => $taxableIncome,
      'tax_amount'       => null,
    ];

    return [
      'year'            => $ledger->fiscal_year,
      'incomeStatement' => $incomeStatement,
      'taxReturn'       => $taxReturn,
    ];
  }
}