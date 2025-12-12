@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
  <section class="py-4">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-5 order-lg-2">
        <div class="card h-100 text-bg-dark bg-gradient border-0 shadow-sm">
          <div class="card-body p-4 p-lg-5 d-flex flex-column">
            <p class="text-uppercase small fw-semibold text-white-50 mb-2">Welcome back</p>
            <h2 class="fs-3 fw-bold mb-3">今日の経理タスクを軽やかに。</h2>
            <p class="text-white-75 mb-4">
              スナップショットで現状を確認し、AI サジェストが未処理の仕訳もサポートします。
            </p>
            <div class="row row-cols-1 gy-3">
              <div class="col d-flex align-items-center">
                <span class="badge rounded-pill text-bg-light text-dark me-3"><i
                    class="bi bi-lightning-charge"></i></span>
                <span>直近活動サマリーで進捗を追跡</span>
              </div>
              <div class="col d-flex align-items-center">
                <span class="badge rounded-pill text-bg-light text-dark me-3"><i class="bi bi-chat-dots"></i></span>
                <span>チャットサポートで質問も即解決</span>
              </div>
              <div class="col d-flex align-items-center">
                <span class="badge rounded-pill text-bg-light text-dark me-3"><i
                    class="bi bi-cloud-arrow-down"></i></span>
                <span>自動バックアップで安心</span>
              </div>
            </div>
            <div class="mt-auto pt-4 small text-white-50">
              <div>最新同期: 3 分前</div>
              <div>年間 1,200+ 申告をサポート</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7 col-xl-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body p-4 p-lg-5">
            <div class="mb-4">
              <span class="badge bg-dark-subtle text-dark fw-semibold px-3 py-2 text-uppercase">Sign in</span>
              <h1 class="h3 mt-3 mb-1">ログイン</h1>
              <p class="text-secondary mb-0">登録済みのメールアドレスとパスワードを入力してください。</p>
            </div>

            <form action="/login" method="POST" class="needs-validation" novalidate>
              @csrf

              <div class="mb-3">
                <label for="login_email" class="form-label">メールアドレス</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                  <input type="email" id="login_email" name="email" value="{{ old('email') }}"
                    placeholder="tax@example.com" class="form-control @error('email') is-invalid @enderror"
                    autocomplete="email" required>
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="login_password" class="form-label">パスワード</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                  <input type="password" id="login_password" name="password" placeholder="Password"
                    class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                  <label class="form-check-label" for="remember_me">ログイン状態を保存</label>
                </div>

                <a class="link-primary" href="{{ route('password.request') }}">パスワードをお忘れですか？</a>
              </div>

              <button type="submit" class="btn btn-dark btn-lg w-100 shadow-sm">ダッシュボードへ進む</button>
            </form>

            <p class="text-center text-secondary mt-4 mb-0">
              まだアカウントをお持ちでない方は
              <a href="{{ route('register') }}">こちらから登録</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
