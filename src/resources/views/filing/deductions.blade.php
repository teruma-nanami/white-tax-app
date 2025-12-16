@extends('layouts.app')

@section('title', $ledger->fiscal_year . '年分 確定申告・控除入力')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">
      {{ $ledger->fiscal_year }}年分 確定申告・控除入力
    </h1>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('filing.deductions.store', ['ledger' => $ledger->id]) }}">
      @csrf

      {{-- ───────── 給与収入・源泉徴収 ───────── --}}
      <div class="card mb-4">
        <div class="card-header">
          給与収入・源泉徴収
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">給与収入（支払金額）</label>
            <input type="number" name="salary_income" class="form-control"
              value="{{ old('salary_income', $taxFilingData->salary_income ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">源泉徴収税額</label>
            <input type="number" name="salary_withholding_tax" class="form-control"
              value="{{ old('salary_withholding_tax', $taxFilingData->salary_withholding_tax ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">給与由来の社会保険料</label>
            <input type="number" name="salary_social_insurance_paid" class="form-control"
              value="{{ old('salary_social_insurance_paid', $taxFilingData->salary_social_insurance_paid ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">給与由来の生命保険料控除</label>
            <input type="number" name="salary_life_insurance_ded" class="form-control"
              value="{{ old('salary_life_insurance_ded', $taxFilingData->salary_life_insurance_ded ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">給与由来の地震保険料控除</label>
            <input type="number" name="salary_earthquake_insurance_ded" class="form-control"
              value="{{ old('salary_earthquake_insurance_ded', $taxFilingData->salary_earthquake_insurance_ded ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">給与側の扶養人数</label>
            <input type="number" name="salary_dependents_count" class="form-control"
              value="{{ old('salary_dependents_count', $taxFilingData->salary_dependents_count ?? '') }}" min="0">
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="salary_spouse_ded_applied" value="1"
              id="salary_spouse_ded_applied"
              {{ old('salary_spouse_ded_applied', $taxFilingData->salary_spouse_ded_applied ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="salary_spouse_ded_applied">
              給与側で配偶者控除が適用されている
            </label>
          </div>

          <div class="mb-3">
            <label class="form-label">非課税通勤手当</label>
            <input type="number" name="salary_commute_allowance_non_taxable" class="form-control"
              value="{{ old('salary_commute_allowance_non_taxable', $taxFilingData->salary_commute_allowance_non_taxable ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">その他給与由来控除</label>
            <input type="number" name="salary_other_deductions" class="form-control"
              value="{{ old('salary_other_deductions', $taxFilingData->salary_other_deductions ?? '') }}" min="0">
          </div>
        </div>
      </div>

      {{-- ───────── 所得控除・保険料・医療・寄附 ───────── --}}
      <div class="card mb-4">
        <div class="card-header">
          所得控除・保険料・医療・寄附
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">生命保険料控除（一般）</label>
            <input type="number" name="life_insurance_general" class="form-control"
              value="{{ old('life_insurance_general', $taxFilingData->life_insurance_general ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">生命保険料控除（介護・医療）</label>
            <input type="number" name="life_insurance_medical" class="form-control"
              value="{{ old('life_insurance_medical', $taxFilingData->life_insurance_medical ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">生命保険料控除（個人年金）</label>
            <input type="number" name="life_insurance_pension" class="form-control"
              value="{{ old('life_insurance_pension', $taxFilingData->life_insurance_pension ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">社会保険料控除</label>
            <input type="number" name="social_insurance_ded" class="form-control"
              value="{{ old('social_insurance_ded', $taxFilingData->social_insurance_ded ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">医療費控除</label>
            <input type="number" name="medical_expense_ded" class="form-control"
              value="{{ old('medical_expense_ded', $taxFilingData->medical_expense_ded ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">寄附金控除（ふるさと納税など）</label>
            <input type="number" name="donation_ded" class="form-control"
              value="{{ old('donation_ded', $taxFilingData->donation_ded ?? '') }}" min="0">
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="spouse_deduction_applied" value="1"
              id="spouse_deduction_applied"
              {{ old('spouse_deduction_applied', $taxFilingData->spouse_deduction_applied ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="spouse_deduction_applied">
              配偶者控除を適用する
            </label>
          </div>

          <div class="mb-3">
            <label class="form-label">扶養親族数</label>
            <input type="number" name="dependent_count" class="form-control"
              value="{{ old('dependent_count', $taxFilingData->dependent_count ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">小規模企業共済等掛金</label>
            <input type="number" name="small_enterprise_mutual_aid" class="form-control"
              value="{{ old('small_enterprise_mutual_aid', $taxFilingData->small_enterprise_mutual_aid ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">iDeCo 拠出額</label>
            <input type="number" name="ideco_contributions" class="form-control"
              value="{{ old('ideco_contributions', $taxFilingData->ideco_contributions ?? '') }}" min="0">
          </div>
        </div>
      </div>

      {{-- ───────── 住宅ローン控除・その他 ───────── --}}
      <div class="card mb-4">
        <div class="card-header">
          住宅ローン控除・その他
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">住宅ローン 年末残高</label>
            <input type="number" name="home_loan_year_end_balance" class="form-control"
              value="{{ old('home_loan_year_end_balance', $taxFilingData->home_loan_year_end_balance ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">住宅ローン控除額</label>
            <input type="number" name="home_loan_deduction_amount" class="form-control"
              value="{{ old('home_loan_deduction_amount', $taxFilingData->home_loan_deduction_amount ?? '') }}"
              min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">住宅ローンの種類</label>
            <input type="text" name="home_loan_type" class="form-control"
              value="{{ old('home_loan_type', $taxFilingData->home_loan_type ?? '') }}">
          </div>

          <div class="mb-3">
            <label class="form-label">住宅ローン控除 何年目か</label>
            <input type="number" name="home_loan_year_number" class="form-control"
              value="{{ old('home_loan_year_number', $taxFilingData->home_loan_year_number ?? '') }}" min="0">
          </div>

          <div class="mb-3">
            <label class="form-label">その他の所得控除</label>
            <input type="number" name="misc_deductions" class="form-control"
              value="{{ old('misc_deductions', $taxFilingData->misc_deductions ?? '') }}" min="0">
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('filing.entries_summary', ['ledger' => $ledger->id]) }}" class="btn btn-outline-secondary">
          年度サマリーに戻る
        </a>

        <button type="submit" class="btn btn-primary">
          控除情報を保存する
        </button>
      </div>
    </form>
  </div>
@endsection
