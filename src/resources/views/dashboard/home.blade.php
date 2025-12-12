@extends('layouts.app')

@section('content')
  <div class="container py-4">

    {{-- ページタイトル --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h3 mb-1">ダッシュボード</h1>
        <p class="text-muted mb-0">白色申告用 簿記管理アプリ</p>
      </div>
    </div>

    {{-- クイックアクション --}}
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <a href="{{ route('entries.index') }}" class="card text-decoration-none h-100">
          <div class="card-body">
            <h5 class="card-title">取引一覧</h5>
            <p class="card-text text-muted">登録済みの取引を確認</p>
          </div>
        </a>
      </div>

      {{-- <div class="col-md-3">
        <a href="{{ route('entries.create') }}" class="card text-decoration-none h-100">
          <div class="card-body">
            <h5 class="card-title">取引登録</h5>
            <p class="card-text text-muted">収入・経費を追加</p>
          </div>
        </a>
      </div>

      <div class="col-md-3">
        <a href="{{ route('filing.annual_summary') }}" class="card text-decoration-none h-100">
          <div class="card-body">
            <h5 class="card-title">年間収支</h5>
            <p class="card-text text-muted">年度ごとの収支サマリー</p>
          </div>
        </a>
      </div>

      <div class="col-md-3">
        <a href="{{ route('filing.preview') }}" class="card text-decoration-none h-100">
          <div class="card-body">
            <h5 class="card-title">確定申告</h5>
            <p class="card-text text-muted">申告書プレビュー</p>
          </div>
        </a>
      </div>
    </div>

    {{-- 状態サマリー（ダミー表示・後で差し替え前提） --}}
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">現在の年度</h6>
              <h4 class="mb-0">{{ now()->year }} 年度</h4>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">取引件数</h6>
              <h4 class="mb-0">— 件</h4>
              <small class="text-muted">※ 後で実データ連携</small>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">申告ステータス</h6>
              <span class="badge bg-secondary">未提出</span>
            </div>
          </div>
        </div>
      </div> --

    </div>
  @endsection
