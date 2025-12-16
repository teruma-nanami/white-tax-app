@extends('layouts.app')

@section('title', $year . '年分 確定申告書プレビュー')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">
      {{ $year }}年分 確定申告書プレビュー
    </h1>

    <p class="text-muted mb-4">
      このページは、{{ $year }}年分の
      <strong>収支決算書</strong> と
      <strong>確定申告書B</strong> の主要項目をプレビュー表示する画面です。<br>
      実際の提出書類は、税務署の様式に従って別途作成してください。
    </p>

    @php
      $fmt = function ($value) {
          if (is_null($value)) {
              return '—';
          }
          return number_format($value) . ' 円';
      };
    @endphp

    {{-- 収支決算書 --}}
    <div class="card mb-4">
      <div class="card-header">
        収支決算書（{{ $year }}年分）
      </div>
      <div class="card-body">

        <h2 class="h5 mb-3">年間サマリー</h2>
        <table class="table table-bordered mb-4">
          <tbody>
            <tr>
              <th style="width: 30%;">収入合計</th>
              <td class="text-end">{{ $fmt($incomeStatement['total_income'] ?? null) }}</td>
            </tr>
            <tr>
              <th>経費合計</th>
              <td class="text-end">{{ $fmt($incomeStatement['total_expense'] ?? null) }}</td>
            </tr>
            <tr>
              <th>差引所得（収入 − 経費）</th>
              <td class="text-end">{{ $fmt($incomeStatement['net_income'] ?? null) }}</td>
            </tr>
          </tbody>
        </table>

        <h2 class="h5 mb-3">経費の内訳（科目別）</h2>

        @if (empty($incomeStatement['expense_breakdown']))
          <div class="alert alert-light mb-0">
            経費の登録がありません。
          </div>
        @else
          <table class="table table-sm table-bordered mb-0">
            <thead>
              <tr>
                <th>科目</th>
                <th class="text-end">金額</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($incomeStatement['expense_breakdown'] as $row)
                <tr>
                  <td>{{ $row['category'] }}</td>
                  <td class="text-end">{{ $fmt($row['amount'] ?? null) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    {{-- 確定申告書B（サマリ） --}}
    <div class="card mb-4">
      <div class="card-header">
        確定申告書B（主要項目プレビュー）
      </div>
      <div class="card-body">
        <table class="table table-bordered mb-3">
          <tbody>
            <tr>
              <th style="width: 35%;">給与所得</th>
              <td class="text-end">{{ $fmt($taxReturn['salary_income'] ?? null) }}</td>
            </tr>
            <tr>
              <th>事業所得（収支決算書の差引所得）</th>
              <td class="text-end">{{ $fmt($taxReturn['business_income'] ?? null) }}</td>
            </tr>
            <tr>
              <th>合計所得金額</th>
              <td class="text-end">{{ $fmt($taxReturn['total_income'] ?? null) }}</td>
            </tr>
            <tr>
              <th>所得控除合計</th>
              <td class="text-end">{{ $fmt($taxReturn['income_deductions'] ?? null) }}</td>
            </tr>
            <tr>
              <th>課税所得金額</th>
              <td class="text-end">{{ $fmt($taxReturn['taxable_income'] ?? null) }}</td>
            </tr>
            <tr>
              <th>所得税額（参考）</th>
              <td class="text-end">
                @if (is_null($taxReturn['tax_amount']))
                  <span class="text-muted">未計算（この画面では税額計算を行いません）</span>
                @else
                  {{ $fmt($taxReturn['tax_amount']) }}
                @endif
              </td>
            </tr>
          </tbody>
        </table>

        <p class="small text-muted mb-0">
          ※ このプレビューは、入力済みの仕訳・控除データを元にした概算イメージです。<br>
          ※ 実際の申告内容は、税務署配布の申告書様式および公式ガイドに従ってください。
        </p>
      </div>
    </div>

    {{-- 戻り導線 --}}
    <div class="d-flex justify-content-between">
      <a href="{{ route('filing.entries_summary', ['ledger' => $ledger->id]) }}" class="btn btn-outline-secondary">
        年度別サマリーへ戻る
      </a>

      <a href="{{ route('filing.deductions.edit', ['ledger' => $ledger->id]) }}" class="btn btn-outline-primary">
        控除情報を修正する
      </a>
    </div>

  </div>
@endsection
