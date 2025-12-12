@extends('layouts.app')

@section('title', 'アカウント登録')

@section('content')
  <section class="py-4">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-5">
        <div class="card h-100 text-bg-primary bg-gradient border-0 shadow-sm">
          <div class="card-body p-4 p-lg-5 d-flex flex-column">
            <p class="text-uppercase small fw-semibold text-white-50 mb-2">はじめての方へ</p>
            <h2 class="fs-3 fw-bold mb-3">白色申告を、もっとスムーズに。</h2>
            <p class="text-white-75 mb-4">
              日々の取引入力から控除の把握まで、Bootstrap のシンプルな画面で迷わず進められます。
            </p>
            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item bg-transparent text-white d-flex align-items-center px-0">
                <i class="bi bi-stars me-2"></i> 無料でスタート
              </li>
              <li class="list-group-item bg-transparent text-white d-flex align-items-center px-0">
                <i class="bi bi-graph-up me-2"></i> 進捗が一目でわかる
              </li>
              <li class="list-group-item bg-transparent text-white d-flex align-items-center px-0">
                <i class="bi bi-shield-check me-2"></i> セキュアなクラウド保存
              </li>
            </ul>
            <div class="mt-auto">
              <div class="d-flex flex-wrap gap-2 small">
                <span class="badge text-bg-light text-primary">サポート：平日 9:00-18:00</span>
                <span class="badge text-bg-light text-primary">平均セットアップ 3 分</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7 col-xl-6 ms-lg-auto">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body p-4 p-lg-5">
            <div class="mb-4">
              <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 text-uppercase">Register</span>
              <h1 class="h3 mt-3 mb-1">アカウントを作成</h1>
              <p class="text-secondary mb-0">基本情報を入力して、すぐにダッシュボードへ。</p>
            </div>

            <form action="/register" method="POST" class="needs-validation" novalidate>
              @csrf

              <div class="mb-3">
                <label for="name" class="form-label">氏名</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                  <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="山田 太郎"
                    class="form-control @error('name') is-invalid @enderror" autocomplete="name" required>
                </div>
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                  <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="tax@example.com" class="form-control @error('email') is-invalid @enderror"
                    autocomplete="email" required>
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                  <input type="password" id="password" name="password" placeholder="8文字以上で設定"
                    class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required>
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-4">
                <label for="password_confirmation" class="form-label">パスワード（確認）</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                  <input type="password" id="password_confirmation" name="password_confirmation" placeholder="同じパスワードを入力"
                    class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password"
                    required>
                </div>
                @error('password_confirmation')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">アカウントを作成</button>
            </form>

            <p class="text-center text-secondary mt-4 mb-0">
              すでにアカウントをお持ちですか？
              <a href="{{ route('login') }}">ログインはこちら</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
