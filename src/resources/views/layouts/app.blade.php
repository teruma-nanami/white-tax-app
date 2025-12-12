<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- Bootstrap（必須） --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  {{-- Google Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">



  @yield('css')

  <title>@yield('title', 'サイトタイトル')</title>
</head>

<body>
  <header class="header border-bottom">
    <div class="container py-3 d-flex justify-content-between align-items-center">
      <h1 class="h5 mb-0">サイトタイトル</h1>

      <nav class="d-flex align-items-center gap-2" id="navMenu">
        @if (auth()->check())
          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-box-arrow-right"></i> ログアウト
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-box-arrow-in-right"></i> ログイン
          </a>
          <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus"></i> 登録
          </a>
        @endif
      </nav>
    </div>
  </header>

  <main class="container py-4">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>

  {{-- Bootstrap JS（必要なら。モーダル等で効く） --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- 既存JS（必要なら） --}}
  {{-- <script src="{{ asset('js/test.js') }}"></script> --}}
</body>

</html>
