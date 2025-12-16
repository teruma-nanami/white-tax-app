<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
  public function authorize(): bool
  {
    // ログイン済みなら OK
    return $this->user() !== null;
  }

  public function rules(): array
  {
    $user = $this->user();
    $userId = $user?->id;

    return [
      'business_name' => ['nullable', 'string', 'max:255'],

      // 文字列で保持（white / blue / NA などを想定）
      'tax_filing_method' => ['nullable', 'string', 'max:50'],

      // checkbox + hidden 0 で飛んでくる前提
      'invoice_enabled' => ['required', 'boolean'],

      'invoice_number' => [
        'nullable',
        'string',
        'max:20',
        'required_if:invoice_enabled,1',
        // 同じ user_id の行は除外してユニークチェック
        Rule::unique('user_profiles', 'invoice_number')
          ->ignore($userId, 'user_id'),
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'invoice_enabled.required' => 'インボイス登録有無を選択してください。',
      'invoice_enabled.boolean'  => 'インボイス登録有無の形式が不正です。',
      'invoice_number.required_if' =>
      'インボイス登録を有効にした場合は、インボイス登録番号を入力してください。',
      'invoice_number.unique' =>
      'このインボイス登録番号はすでに他のユーザーで使用されています。',
    ];
  }
}