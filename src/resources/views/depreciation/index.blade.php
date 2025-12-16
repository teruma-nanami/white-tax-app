@extends('layouts.app')

@section('title', $year . '年 減価償却費候補一覧')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">
      {{ $year }}年 減価償却費候補一覧
    </h1>

    <p class="text-muted">
      このページでは、{{ number_format($threshold) }}円以上の高額経費のうち、
      減価償却の対象となりうる取引を一覧表示します。<br>
      <strong>※ このページは「備忘録」用途であり、減価償却費の自動計算は行いません。</strong><br>
      実際の耐用年数・償却額については、税務署のガイドや税理士等に必ず確認してください。
    </p>

    @if ($entries->isEmpty())
      <div class="alert alert-light mt-4">
        減価償却の対象となる高額経費は登録されていません。
      </div>
    @else
      <table class="table table-bordered mt-4">
        <thead>
          <tr>
            <th style="width: 120px;">取引日</th>
            <th>摘要</th>
            <th>科目</th>
            <th class="text-end" style="width: 160px;">金額（税込）</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            <tr>
              <td>
                {{ optional($entry->transaction_date)->format('Y-m-d') }}
              </td>
              <td>{{ $entry->description ?? '（摘要未入力）' }}</td>
              <td>{{ optional($entry->category)->category_name ?? '不明な科目' }}</td>
              <td class="text-end">
                {{ number_format($entry->amount_inc_tax) }} 円
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    <div class="mt-4">
      <a href="{{ route('filing.entries_summary', ['ledger' => $ledger->id]) }}" class="btn btn-outline-secondary">
        年度別サマリーに戻る
      </a>
    </div>

    <div class="mt-3">
      <p class="small text-muted mb-0">
        ※ 10万円以上20万円未満の少額減価償却資産は、原則として3年均等償却などの特例が適用されることがあります。<br>
        ※ 20万円以上の資産については、法定耐用年数表に従い、定額法などで減価償却額を計算してください。
      </p>
    </div>

  </div>
@endsection
