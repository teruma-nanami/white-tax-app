<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntryRequest extends FormRequest
{
    /**
     * 認可
     * 今回は EntryPolicy を使わないため true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'transaction_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:255'],
            'partner_name' => ['nullable', 'string', 'max:255'],
            'amount_inc_tax' => ['required', 'numeric'],
            'is_invoice_received' => ['sometimes', 'boolean'],
            'is_capitalized' => ['sometimes', 'boolean'],
            'is_recurring' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * boolean フィールドの正規化
     * checkbox 未送信対策
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_invoice_received' => $this->boolean('is_invoice_received'),
            'is_capitalized'      => $this->boolean('is_capitalized'),
            'is_recurring'        => $this->boolean('is_recurring'),
        ]);
    }
}