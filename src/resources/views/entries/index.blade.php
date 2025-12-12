@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h4">{{ $year }}年 取引一覧</h1>

      <a href="{{ route('entries.create') }}" class="btn btn-primary">
        ＋ 取引を追加
      </a>
    </div>

    @if ($entries->isEmpty())
      <div class="alert alert-secondary">
        取引はまだ登録されていません。
      </div>
    @else
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>日付</th>
            <th>内容</th>
            <th class="text-end">金額（税込）</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            <tr>
              <td>{{ $entry->transaction_date->format('Y-m-d') }}</td>
              <td>{{ $entry->description }}</td>
              <td class="text-end">
                {{ number_format($entry->amount_inc_tax) }} 円
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
@endsection
