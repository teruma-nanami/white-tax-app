@extends('layouts.app')

@section('title', 'カテゴリー表示変更')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-4">カテゴリー表示変更</h1>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if ($categories->isEmpty())
      <div class="alert alert-light">
        カテゴリがありません。
      </div>
    @else
      <form method="POST" action="{{ route('categories.update') }}">
        @csrf
        @method('PUT')

        <p class="text-muted small">
          表示したいカテゴリにチェックを入れてください。<br>
          チェックを外したカテゴリは、取引登録画面などで非表示になります。
        </p>

        <div class="card mb-3">
          <div class="card-body">

            <div class="row">
              @foreach ($categories as $category)
                <div class="col-md-4 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category_ids[]"
                      id="category_{{ $category->id }}" value="{{ $category->id }}"
                      {{ in_array($category->id, old('category_ids', $visibleCategoryIds), true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->id }}">
                      {{ $category->category_name }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>

          </div>
        </div>

        <button type="submit" class="btn btn-primary">
          設定を保存する
        </button>
      </form>
    @endif

  </div>
@endsection
