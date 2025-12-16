@extends('layouts.app')

@section('title', $year . '年 インボイス収支一覧')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">
      {{ $year }}年 インボイス収支一覧
    </h1>

    <p class="text-muted">
      このページには、インボイス登録番号が紐づいている取引のみが表示されます。<br>
      金額はすべて税込金額ベースです。
    </p>

    {{-- サマリー --}}
    <div class="row mb-4">
      <div class="col-md-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="text-muted small">インボイス対象収入合計</div>
            <div class="fs-5 fw-bold">
              {{ number_format($summary['invoice_income']) }} 円
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="text-muted small">インボイス対象支出合計</div>
            <div class="fs-5 fw-bold">
              {{ number_format($summary['invoice_expense']) }} 円
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="text-muted small">インボイス対象収支</div>
            <div class="fs-5 fw-bold">
              {{ number_format($summary['invoice_balance']) }} 円
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- 一覧 --}}
    @if ($entries->isEmpty())
      <div class="alert alert-light">
        インボイス対象の取引はありません。
      </div>
    @else
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th style="width: 140px;">取引日</th>
            <th>摘要</th>
            <th>インボイス番号</th>
            <th style="width: 140px;" class="text-end">金額（税込）</th>
            <th style="width: 80px;">区分</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            @php
              $type = $entry->category->default_type ?? null;
              $label = $type === 'Revenue' ? '収入' : ($type === 'Expense' ? '支出' : '―');
            @endphp
            <tr>
              <td>
                {{ $entry->transaction_date->format('Y-m-d') }}
              </td>
              <td>
                {{ $entry->description }}
                @if (!empty($entry->partner_name))
                  <div class="text-muted small">
                    取引先：{{ $entry->partner_name }}
                  </div>
                @endif
                @if ($entry->category)
                  <div class="text-muted small">
                    科目：{{ $entry->category->category_name }}
                  </div>
                @endif
              </td>
              <td>
                {{ $entry->invoice_number }}
              </td>
              <td class="text-end">
                {{ number_format($entry->amount_inc_tax) }} 円
              </td>
              <td>
                {{ $label }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
@endsection
