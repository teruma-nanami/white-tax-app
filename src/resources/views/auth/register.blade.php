@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Registration</h2>
    <form action="/register" method="post" class="form">
      @csrf
      <div class="form__inner">
        <div class="form__inner-text">
          <i class="bi bi-person-circle"></i>
          <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
        </div>
        <div class="form__error">
          @error('name')
            {{ $message }}
          @enderror
        </div>
        <div class="form__inner-text">
          <i class="bi bi-envelope-fill"></i>
          <input type="text" name="email" placeholder="email" value="{{ old('email') }}">
        </div>
        <div class="form__error">
          @error('email')
            {{ $message }}
          @enderror
        </div>
        <div class="form__inner-text">
          <i class="bi bi-key-fill"></i>
          <input type="password" name="password" placeholder="password">
        </div>
        <div class="form__error">
          @error('password')
            {{ $message }}
          @enderror
        </div>
        <div class="form__inner-text">
          <i class="bi bi-key-fill"></i>
          <input type="password" name="password_confirmation" placeholder="password_confirmation">
        </div>
        <div class="form__button">
          <button type="submit">登録</button>
        </div>
      </div>
    </form>
  </div>
@endsection
