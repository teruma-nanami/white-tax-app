@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Password Reset</h2>
    <form method="POST" action="{{ route('password.update') }}" class="form">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">
      <div class="form__inner">
        <div class="form__inner-text">
          <label for="email"><i class="bi bi-envelope-fill"></i></label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" required
            autofocus>
        </div>
        <div class="form__inner-text">
          <label for="password"><i class="bi bi-key-fill"></i></label>
          <input id="password" type="password" name="password" placeholder="パスワード" required>
        </div>
        <div class="form__inner-text">
          <label for="password_confirmation"><i class="bi bi-key-fill"></i></label>
          <input id="password_confirmation" type="password" name="password_confirmation" placeholder="確認用パスワード" required>
        </div>
        <div class="form__button">
          <button type="submit">パスワードを再設定</button>
        </div>
      </div>
    </form>
  </div>
@endsection
