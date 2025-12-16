@extends('layouts.app')

@section('title', '確定申告一覧')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">確定申告一覧</h1>

    @if ($ledgers->isEmpty())
      <div class="alert alert-light">
        確定申告データはまだありません。
      </div>
    @else
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th style="width: 20%;">年度</th>
            <th style="width: 30%;">ステータス</th>
            <th style="width: 30%;">ロック日時</th>
            <th style="width: 20%;">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ledgers as $ledger)
            <tr>
              <td>
                {{-- 年度表示（例：2025年） --}}
                {{ $ledger->fiscal_year }}年
              </td>
              <td>
                {{-- status は draft / closed などを想定。とりあえずそのまま表示 --}}
                {{ $ledger->status }}
              </td>
              <td>
                {{ $ledger->locked_at ? $ledger->locked_at->format('Y-m-d H:i') : '未ロック' }}
              </td>
              <td>
                {{-- 確定申告詳細（仕訳集計等）への遷移ボタン --}}
                <a href="{{ route('filing.entries_summary', ['ledger' => $ledger->id]) }}" class="btn btn-sm btn-primary">
                  この年度の申告を見る
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
@endsection
