@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <h1 class="h4 mb-4">取引登録</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('entries.store') }}">
      @csrf

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">取引日</label>
          <input type="date" name="transaction_date" class="form-control"
            value="{{ old('transaction_date', now()->toDateString()) }}" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">金額（税込）</label>
          <input type="number" name="amount_inc_tax" class="form-control" value="{{ old('amount_inc_tax') }}" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">カテゴリ</label>
        <select name="category_id" class="form-select" required>
          <option value="">選択してください</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">
              {{ $category->category_name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">税区分</label>
        <select name="tax_rule_id" class="form-select" required>
          @foreach ($taxRules as $rule)
            <option value="{{ $rule->id }}">
              {{ $rule->rule_type }}
            </option>
          @endforeach
        </select>
        <input type="hidden" name="tax_category" value="StandardTax">
      </div>

      <div class="mb-3">
        <label class="form-label">内容</label>
        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
      </div>

      <div class="mb-3">
        <label class="form-label">取引先</label>
        <input type="text" name="partner_name" class="form-control" value="{{ old('partner_name') }}">
      </div>

      <div class="form-check mb-4">
        <input type="checkbox" name="is_recurring" class="form-check-input" id="isRecurring">
        <label class="form-check-label" for="isRecurring">
          定期取引
        </label>
      </div>

      <button type="submit" class="btn btn-primary">
        登録する
      </button>
    </form>
  </div>
@endsection
