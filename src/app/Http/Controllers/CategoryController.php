<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    /**
     * カテゴリー表示変更画面
     */
    public function edit()
    {
        $userId = Auth::id();

        $data = $this->categoryService->getCategoriesForEdit($userId);

        return view('categories.edit', [
            'categories'        => $data['categories'],
            'visibleCategoryIds' => $data['visibleCategoryIds'],
        ]);
    }

    /**
     * カテゴリー表示設定の更新
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'category_ids'   => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
        ]);

        $userId = Auth::id();
        $categoryIds = $validated['category_ids'] ?? [];

        $this->categoryService->updateVisibility($userId, $categoryIds);

        return redirect()
            ->route('categories.edit')
            ->with('success', 'カテゴリー表示設定を更新しました。');
    }
}