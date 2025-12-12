<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/variables.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
  @yield('css')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <title>サイトタイトル</title>
</head>

<body>
  <header class="header">

    <div class="header__inner">
      <h1>
        サイトタイトル
      </h1>
      <div class="header__nav" id="navMenu">
        <ul>
          @if (auth()->check())
            <li>
              <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout__button"> <i class="bi bi-box-arrow-right"></i> ログアウト</button>
              </form>
            </li>
          @else
            <li>
              <a href="{{ route('login') }}" class="login__button"> <i class="bi bi-box-arrow-in-right"></i> ログイン</a>
              <a href="{{ route('register') }}" class="register__button"> <i class="bi bi-person-plus"></i> 登録</a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </header>
  <main>
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
    {{-- @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif --}}
    @yield('content')
  </main>
  <script src="{{ asset('js/test.js') }}"></script>
  </ </body>

</html>
