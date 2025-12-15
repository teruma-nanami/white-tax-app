@extends('layouts.app')

@section('title', 'お知らせ')

@section('content')
  <div class="container py-4">
    <h1 class="h4 mb-4">お知らせ</h1>

    @if (empty($notifications))
      <div class="alert alert-light">
        現在お知らせはありません。
      </div>
    @else
      <div class="list-group">
        @foreach ($notifications as $notification)
          <div class="list-group-item mb-3">
            <div class="fw-bold mb-1">
              {{ $notification['title'] }}
            </div>
            <div class="text-muted small mb-2">
              {{ $notification['published_at'] }}
            </div>
            <div>
              {{ $notification['body'] }}
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
