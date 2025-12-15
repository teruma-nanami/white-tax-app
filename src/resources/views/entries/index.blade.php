@extends('layouts.app')

@section('title', '取引一覧')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">
      {{ $year }}年 取引一覧
    </h1>

    @if ($entries->isEmpty())
      <div class="alert alert-light">
        取引はまだありません。
      </div>
    @else
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>取引日</th>
            <th>摘要</th>
            <th class="text-end">金額（税込）</th>
            <th>区分</th>
            <th class="text-center">操作</th>
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
              <td>
                @php
                  $type = $entry->category?->default_type ?? null;
                @endphp
                {{ $type === 'Revenue' ? '収入' : ($type === 'Expense' ? '支出' : ($entry->amount_inc_tax >= 0 ? '収入' : '支出')) }}
              </td>
              <td class="text-center">
                <a href="{{ route('entries.edit', $entry->id) }}" class="btn btn-sm btn-outline-primary">
                  編集
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
@endsection
