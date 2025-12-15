@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="mb-4">ダッシュボード</h1>

    <div class="row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">年間収入</h5>
            <p class="card-text">
              {{ $annualSummary['income'] ?? 0 }} 円
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">年間支出</h5>
            <p class="card-text">
              {{ $annualSummary['expense'] ?? 0 }} 円
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">年間収支差額</h5>
            <p class="card-text">
              {{ $annualSummary['balance'] ?? 0 }} 円
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
