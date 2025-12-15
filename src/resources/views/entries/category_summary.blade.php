@extends('layouts.app')

@section('title', 'カテゴリー別集計')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">
      {{ $year }}年 カテゴリー別集計（支出）
    </h1>

    @if ($categorySummaries->isEmpty())
      <div class="alert alert-light">
        当年度の集計対象となる取引はありません。
      </div>
    @else
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>カテゴリ</th>
            <th class="text-end">合計金額（税込）</th>
            <th class="text-end">件数</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categorySummaries as $row)
            <tr>
              <td>{{ $row->category_name }}</td>
              <td class="text-end">
                {{ number_format($row->total) }} 円
              </td>
              <td class="text-end">
                {{ $row->count }} 件
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
