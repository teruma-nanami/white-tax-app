@extends('layouts.app')

@section('title', '取引編集')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">
      取引編集
    </h1>

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

    <form method="POST" action="{{ route('entries.update', $entry->id) }}">
      @csrf
      @method('PUT')

      {{-- 取引日 --}}
      <div class="mb-3">
        <label class="form-label">取引日</label>
        <input type="date" name="transaction_date" class="form-control"
          value="{{ old('transaction_date', $entry->transaction_date->format('Y-m-d')) }}" required>
      </div>

      {{-- 摘要 --}}
      <div class="mb-3">
        <label class="form-label">摘要</label>
        <input type="text" name="description" class="form-control"
          value="{{ old('description', $entry->description) }}">
      </div>

      {{-- 取引先 --}}
      <div class="mb-3">
        <label class="form-label">取引先</label>
        <input type="text" name="partner_name" class="form-control"
          value="{{ old('partner_name', $entry->partner_name) }}">
      </div>

      {{-- 金額（税込） --}}
      <div class="mb-3">
        <label class="form-label">金額（税込）</label>
        <input type="number" name="amount_inc_tax" class="form-control"
          value="{{ old('amount_inc_tax', $entry->amount_inc_tax) }}" required>
      </div>

      {{-- インボイス関連 --}}
      @if ($isInvoiceEnabled)
        <div class="mb-3">
          <label class="form-label">インボイス登録番号</label>
          <input type="text" name="invoice_number" class="form-control"
            value="{{ old('invoice_number', $entry->invoice_number) }}">
        </div>
      @endif

      {{-- 原価償却対象 --}}
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_capitalized" value="1"
          {{ old('is_capitalized', $entry->is_capitalized) ? 'checked' : '' }}>
        <label class="form-check-label">
          10万円以上の資産（原価償却対象）
        </label>
      </div>


      {{-- ボタン --}}
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          更新
        </button>

        <a href="{{ route('entries.index') }}" class="btn btn-outline-secondary">
          戻る
        </a>
      </div>

    </form>

  </div>
@endsection
