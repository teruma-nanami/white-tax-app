@extends('layouts.app')

@section('title', $year . '年 減価償却費の登録')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">
      {{ $year }}年 減価償却費の登録
    </h1>

    <p class="text-muted">
      この画面では、{{ $year }}年分の<strong>減価償却費</strong>として計上する金額を登録します。<br>
      登録されたデータは、通常の「取引（Entry）」として保存され、収支決算書や確定申告書プレビューに反映されます。<br>
      <strong>※ 減価償却額の計算（耐用年数・月割等）はここでは行いません。</strong><br>
      金額や内容は、税務署のガイドや専門家に確認のうえ入力してください。
    </p>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('filing.depreciation.store', ['ledger' => $ledger->id]) }}">
      @csrf

      {{-- 取引日 --}}
      <div class="mb-3">
        <label class="form-label">取引日 <span class="text-danger">*</span></label>
        <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
          value="{{ old('transaction_date', $year . '-12-31') }}">
        @error('transaction_date')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
          通常は{{ $year }}年の年末（{{ $year }}-12-31 など）を指定します。
        </div>
      </div>

      {{-- 摘要 --}}
      <div class="mb-3">
        <label class="form-label">摘要</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
          value="{{ old('description') }}" placeholder="例）PC一式、什器など">
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
          空欄の場合、「減価償却費」という摘要のみで登録されます。
        </div>
      </div>

      {{-- 取引先（任意） --}}
      <div class="mb-3">
        <label class="form-label">取引先（任意）</label>
        <input type="text" name="partner_name" class="form-control @error('partner_name') is-invalid @enderror"
          value="{{ old('partner_name') }}" placeholder="例）◯◯ショップ">
        @error('partner_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- 金額（税込） --}}
      <div class="mb-3">
        <label class="form-label">金額（税込） <span class="text-danger">*</span></label>
        <input type="number" name="amount_inc_tax" class="form-control @error('amount_inc_tax') is-invalid @enderror"
          value="{{ old('amount_inc_tax') }}" min="1">
        @error('amount_inc_tax')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
          減価償却として計上する金額を入力してください（税抜きではなく税込み金額）。
        </div>
      </div>

      {{-- 科目 --}}
      <div class="mb-3">
        <label class="form-label">科目 <span class="text-danger">*</span></label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
          <option value="">選択してください</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
              {{ $category->category_name }}
            </option>
          @endforeach
        </select>
        @error('category_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
          減価償却費として計上する際に使用する「経費科目」を選択してください。
        </div>
      </div>

      {{-- ボタン --}}
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">
          減価償却費を登録する
        </button>
        <a href="{{ route('filing.depreciation.index', ['ledger' => $ledger->id]) }}"
          class="btn btn-outline-secondary ms-2">
          減価償却候補一覧に戻る
        </a>
      </div>

    </form>

  </div>
@endsection
