<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductionRequest extends FormRequest
{
	public function authorize(): bool
	{
		// 認証は middleware で担保しているので true でOK
		return true;
	}

	public function rules(): array
	{
		return [
			// ───── 給与関連 ─────
			'salary_income'                      => ['nullable', 'integer', 'min:0'],
			'salary_withholding_tax'             => ['nullable', 'integer', 'min:0'],
			'salary_social_insurance_paid'       => ['nullable', 'integer', 'min:0'],
			'salary_life_insurance_ded'          => ['nullable', 'integer', 'min:0'],
			'salary_earthquake_insurance_ded'    => ['nullable', 'integer', 'min:0'],
			'salary_dependents_count'            => ['nullable', 'integer', 'min:0'],
			'salary_spouse_ded_applied'          => ['nullable', 'boolean'],
			'salary_commute_allowance_non_taxable' => ['nullable', 'integer', 'min:0'],
			'salary_other_deductions'            => ['nullable', 'integer', 'min:0'],

			// ───── 所得控除 ─────
			'life_insurance_general'             => ['nullable', 'integer', 'min:0'],
			'life_insurance_medical'             => ['nullable', 'integer', 'min:0'],
			'life_insurance_pension'             => ['nullable', 'integer', 'min:0'],
			'social_insurance_ded'               => ['nullable', 'integer', 'min:0'],
			'medical_expense_ded'                => ['nullable', 'integer', 'min:0'],
			'donation_ded'                       => ['nullable', 'integer', 'min:0'],
			'spouse_deduction_applied'           => ['nullable', 'boolean'],
			'dependent_count'                    => ['nullable', 'integer', 'min:0'],
			'small_enterprise_mutual_aid'        => ['nullable', 'integer', 'min:0'],
			'ideco_contributions'                => ['nullable', 'integer', 'min:0'],

			// ───── 住宅ローン + その他 ─────
			'home_loan_year_end_balance'         => ['nullable', 'integer', 'min:0'],
			'home_loan_deduction_amount'         => ['nullable', 'integer', 'min:0'],
			'home_loan_type'                     => ['nullable', 'string', 'max:100'],
			'home_loan_year_number'              => ['nullable', 'integer', 'min:0'],
			'misc_deductions'                    => ['nullable', 'integer', 'min:0'],
		];
	}

	public function attributes(): array
	{
		return [
			// 給与関連
			'salary_income'                      => '給与収入（支払金額）',
			'salary_withholding_tax'             => '源泉徴収税額',
			'salary_social_insurance_paid'       => '給与由来の社会保険料',
			'salary_life_insurance_ded'          => '給与由来の生命保険料控除',
			'salary_earthquake_insurance_ded'    => '給与由来の地震保険料控除',
			'salary_dependents_count'            => '給与側の扶養人数',
			'salary_spouse_ded_applied'          => '給与側の配偶者控除適用',
			'salary_commute_allowance_non_taxable' => '非課税通勤手当',
			'salary_other_deductions'            => 'その他給与由来控除',

			// 所得控除
			'life_insurance_general'             => '生命保険料控除（一般）',
			'life_insurance_medical'             => '生命保険料控除（介護・医療）',
			'life_insurance_pension'             => '生命保険料控除（個人年金）',
			'social_insurance_ded'               => '社会保険料控除',
			'medical_expense_ded'                => '医療費控除',
			'donation_ded'                       => '寄附金控除',
			'spouse_deduction_applied'           => '配偶者控除適用',
			'dependent_count'                    => '扶養親族数',
			'small_enterprise_mutual_aid'        => '小規模企業共済等掛金控除',
			'ideco_contributions'                => 'iDeCo拠出額',

			// 住宅ローン + その他
			'home_loan_year_end_balance'         => '住宅ローン 年末残高',
			'home_loan_deduction_amount'         => '住宅ローン控除額',
			'home_loan_type'                     => '住宅ローンの種類',
			'home_loan_year_number'              => '住宅ローン控除 何年目か',
			'misc_deductions'                    => 'その他の所得控除',
		];
	}
}