@extends('layouts.app')

@section('title', '減価償却対象一覧')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">
      {{ $year }}年 減価償却対象候補
    </h1>

    <p class="text-muted mb-4">
      経費のうち {{ number_format($threshold) }} 円以上の取引が表示されます。
    </p>

    @if ($entries->isEmpty())
      <div class="alert alert-light">
        該当する取引はありません。
      </div>
    @else
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>取引日</th>
            <th>摘要</th>
            <th>カテゴリ</th>
            <th class="text-end">金額（税込）</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            <tr>
              <td>{{ $entry->transaction_date->format('Y-m-d') }}</td>
              <td>{{ $entry->description }}</td>
              <td>{{ $entry->category->category_name }}</td>
              <td class="text-end">
                {{ number_format($entry->amount_inc_tax) }} 円
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    <div class="mt-4">
      <a href="{{ route('entries.index') }}" class="btn btn-secondary">
        取引一覧に戻る
      </a>
    </div>

  </div>
@endsection
