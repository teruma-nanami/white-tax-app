@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">プロフィール編集</h1>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="mb-3">
      <span class="text-muted small d-block">ログイン中のユーザー</span>
      <strong>{{ $user->name }}</strong>
      <div class="text-muted small">
        {{ $user->email }}
      </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('PUT')

      {{-- 事業名 --}}
      <div class="mb-3">
        <label class="form-label">事業名（屋号など）</label>
        <input type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror"
          value="{{ old('business_name', $profile?->business_name) }}" placeholder="例：ななみデザイン事務所">
        @error('business_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- 確定申告区分（テキスト入力。white / blue / NA など） --}}
      <div class="mb-3">
        <label class="form-label">確定申告区分</label>
        <input type="text" name="tax_filing_method"
          class="form-control @error('tax_filing_method') is-invalid @enderror"
          value="{{ old('tax_filing_method', $profile?->tax_filing_method) }}" placeholder="例：white / blue / NA など">
        @error('tax_filing_method')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror>
      </div>

      @php
        $invoiceEnabledOld = old('invoice_enabled', $profile?->invoice_enabled ? '1' : '0');
      @endphp

      {{-- インボイス登録有無 --}}
      <div class="mb-3">
        <label class="form-label d-block">インボイス登録</label>

        {{-- チェックを外したとき用の hidden 0 --}}
        <input type="hidden" name="invoice_enabled" value="0">

        <div class="form-check">
          <input class="form-check-input @error('invoice_enabled') is-invalid @enderror" type="checkbox"
            id="invoice_enabled" name="invoice_enabled" value="1" {{ $invoiceEnabledOld == '1' ? 'checked' : '' }}>
          <label class="form-check-label" for="invoice_enabled">
            インボイス登録を行っている
          </label>
          @error('invoice_enabled')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-text">
          インボイス登録を行っている場合のみチェックを入れてください。
        </div>
      </div>

      {{-- インボイス登録番号（有効時のみ表示） --}}
      <div class="mb-3" id="invoice_number_group" style="{{ $invoiceEnabledOld == '1' ? '' : 'display:none;' }}">
        <label class="form-label">インボイス登録番号</label>
        <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror"
          value="{{ old('invoice_number', $profile?->invoice_number) }}" placeholder="例：T1234567890123">
        @error('invoice_number')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
          インボイス制度に登録済みの場合のみ入力してください。
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-primary">
          更新する
        </button>
        <a href="{{ route('dashboard.home') ?? url('/dashboard') }}" class="btn btn-outline-secondary ms-2">
          ダッシュボードに戻る
        </a>
      </div>
    </form>
  </div>

  {{-- インボイス番号欄の表示切り替え --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const checkbox = document.getElementById('invoice_enabled');
      const group = document.getElementById('invoice_number_group');

      if (checkbox && group) {
        checkbox.addEventListener('change', function() {
          group.style.display = this.checked ? '' : 'none';
        });
      }
    });
  </script>
@endsection
