@extends('layouts.app')

@section('title', '会計年度ロック設定')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">会計年度ロック設定</h1>

    {{-- フラッシュメッセージ --}}
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

    <div class="card">
      <div class="card-body">

        <p class="mb-2">
          対象年度：
          <strong>{{ $ledger->fiscal_year }}年分</strong>
        </p>

        @if ($ledger->status === 'Locked')
          {{-- ロック済み表示 --}}
          <div class="alert alert-info">
            この年度はロックされています。<br>
            ロック日時：
            {{ optional($ledger->locked_at)->format('Y-m-d H:i') ?? '不明' }}
          </div>

          <p class="text-muted small mb-0">
            ロックされた年度の取引は、登録・編集・削除ができません。
          </p>
        @else
          {{-- 未ロックの場合の注意文＋ボタン --}}
          <div class="alert alert-warning">
            <strong>⚠ 一度ロックすると、いかなる理由でも解除できません。</strong><br>
            ロック後は、この年度の取引の登録・編集・削除ができなくなります。
          </div>

          <form method="POST" action="{{ route('settings.ledger_status') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
              この年度をロックする
            </button>
          </form>
        @endif

      </div>
    </div>

  </div>
@endsection
