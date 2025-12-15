@extends('layouts.app')

@section('title', '取引登録')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">取引登録</h1>

    <form method="POST" action="{{ route('entries.store') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">取引日</label>
        <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">金額（税込）</label>
        <input type="number" name="amount_inc_tax" class="form-control" value="{{ old('amount_inc_tax') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">摘要</label>
        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
      </div>

      <div class="mb-3">
        <label class="form-label">取引先</label>
        <input type="text" name="partner_name" class="form-control" value="{{ old('partner_name') }}">
      </div>

      @if ($isInvoiceEnabled)
        <div class="mb-3">
          <label class="form-label">インボイス登録番号</label>
          <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number') }}">
        </div>
      @endif

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_invoice_received" value="1">
        <label class="form-check-label">インボイス受領済み</label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_capitalized" value="1">
        <label class="form-check-label">10万円以上の資産</label>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="is_recurring" value="1">
        <label class="form-check-label">定期取引</label>
      </div>

      <button type="submit" class="btn btn-primary">
        登録
      </button>
    </form>

  </div>
@endsection
