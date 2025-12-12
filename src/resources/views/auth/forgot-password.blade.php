@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Password Reset</h2>
    <form method="POST" action="{{ route('password.email') }}" class="form">
      @csrf
      <div class="form__inner">
        <p>パスワードを忘れてしまった場合、メールアドレスを入力してください。</p>
        <div class="form__inner-text">
          <i class="bi bi-envelope-fill"></i>
          <label for="email"></label>
          <input id="email" type="email" name="email" placeholder="email" required autofocus>
        </div>
        <div class="form__button">
          <button type="submit">送信</button>
        </div>
      </div>
    </form>
  </div>
@endsection
