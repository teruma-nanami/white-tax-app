<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepreciationRequest extends FormRequest
{
  public function authorize(): bool
  {
    // 認証ユーザーならOK（auth ミドルウェア前提）
    return auth()->check();
  }

  public function rules(): array
  {
    return [
      'transaction_date' => ['required', 'date'],
      'amount_inc_tax'   => ['required', 'integer', 'min:1'],
      'description'      => ['nullable', 'string', 'max:255'],
      'partner_name'     => ['nullable', 'string', 'max:255'],
      'category_id'      => ['required', 'exists:categories,id'],
    ];
  }

  public function attributes(): array
  {
    return [
      'transaction_date' => '取引日',
      'amount_inc_tax'   => '金額',
      'description'      => '摘要',
      'partner_name'     => '取引先',
      'category_id'      => '科目',
    ];
  }
}