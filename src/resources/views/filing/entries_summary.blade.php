@extends('layouts.app')

@section('title', $year . '年の確定申告サマリー')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">
      {{ $year }}年の確定申告サマリー
    </h1>

    {{-- 年間サマリー（収入 / 支出 / 差額） --}}
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card border-success">
          <div class="card-body">
            <h2 class="h6 text-muted">年間収入合計</h2>
            <p class="fs-4 mb-0 text-success">
              {{ number_format($summary['income']) }} 円
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card border-danger">
          <div class="card-body">
            <h2 class="h6 text-muted">年間支出合計</h2>
            <p class="fs-4 mb-0 text-danger">
              {{ number_format($summary['expense']) }} 円
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card border-primary">
          <div class="card-body">
            <h2 class="h6 text-muted">年間収支（差額）</h2>
            @php
              $balance = $summary['balance'];
            @endphp
            <p class="fs-4 mb-0 {{ $balance >= 0 ? 'text-primary' : 'text-danger' }}">
              {{ number_format($balance) }} 円
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- 仕訳一覧（概要） --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 mb-0">仕訳一覧（{{ $entries->count() }} 件）</h2>

      <a href="{{ route('filing.index') }}" class="btn btn-outline-secondary btn-sm">
        確定申告一覧に戻る
      </a>
    </div>

    @if ($entries->isEmpty())
      <div class="alert alert-light">
        この年度の仕訳はまだありません。
      </div>
    @else
      <table class="table table-sm table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 12%;">取引日</th>
            <th style="width: 20%;">科目</th>
            <th>摘要</th>
            <th style="width: 15%;" class="text-end">金額（税込）</th>
            <th style="width: 10%;">種別</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            @php
              $category = $entry->category;
              $type = $category?->default_type; // Revenue / Expense
              $isIncome = $type === 'Revenue';
            @endphp
            <tr>
              <td>{{ $entry->transaction_date->format('Y-m-d') }}</td>
              <td>{{ $category?->category_name ?? '（不明な科目）' }}</td>
              <td>{{ $entry->description }}</td>
              <td class="text-end">
                {{ number_format($entry->amount_inc_tax) }} 円
              </td>
              <td>
                <span class="badge {{ $isIncome ? 'bg-success' : 'bg-danger' }}">
                  {{ $isIncome ? '収入' : '支出' }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
@endsection
