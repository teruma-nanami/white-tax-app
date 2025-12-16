<?php

namespace App\Services;

use App\Models\Category;
use App\Models\UserPreference;
use Illuminate\Support\Facades\DB;

class CategoryService
{
  /**
   * カテゴリー表示変更画面用データ取得
   *
   * @return array{categories:\Illuminate\Support\Collection, visibleCategoryIds:array<int>}
   */
  public function getCategoriesForEdit(int $userId): array
  {
    // マスタカテゴリ一覧（名称順に並べておく）
    $categories = Category::orderBy('category_name')->get();

    // ユーザーの設定を取得（category_id をキーに）
    $preferences = UserPreference::where('user_id', $userId)
      ->get()
      ->keyBy('category_id');

    $visibleCategoryIds = [];

    foreach ($categories as $category) {
      /** @var \App\Models\UserPreference|null $pref */
      $pref = $preferences->get($category->id);

      // 設定がない or is_hidden = false → 表示扱い
      if (!$pref || !$pref->is_hidden) {
        $visibleCategoryIds[] = $category->id;
      }
    }

    return [
      'categories'        => $categories,
      'visibleCategoryIds' => $visibleCategoryIds,
    ];
  }

  /**
   * カテゴリーの表示／非表示設定を更新
   *
   * @param  int   $userId
   * @param  array<int> $categoryIds  「表示するカテゴリID」の配列
   */
  public function updateVisibility(int $userId, array $categoryIds): void
  {
    // int キャスト＋重複除去
    $visibleIds = array_unique(array_map('intval', $categoryIds));

    // 全カテゴリIDを取得
    $allCategoryIds = Category::pluck('id')->all();

    DB::transaction(function () use ($userId, $visibleIds, $allCategoryIds) {
      // いったんこのユーザーの設定を全削除
      UserPreference::where('user_id', $userId)->delete();

      // 全カテゴリについて「表示／非表示」を書き直す
      $rows = [];

      foreach ($allCategoryIds as $categoryId) {
        $rows[] = [
          'user_id'     => $userId,
          'category_id' => $categoryId,
          // visibleIds に含まれていれば表示、それ以外は非表示
          'is_hidden'   => !in_array($categoryId, $visibleIds, true),
          'created_at'  => now(),
          'updated_at'  => now(),
        ];
      }

      if (!empty($rows)) {
        UserPreference::insert($rows);
      }
    });
  }
}