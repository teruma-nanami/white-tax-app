<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_date' => ['required', 'date'],
            'amount_inc_tax'   => ['required', 'numeric'],
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'tax_rule_id'      => ['required', 'integer', 'exists:tax_rules,id'],
            'tax_category'     => ['required', 'string', 'max:50'],

            'description'     => ['nullable', 'string'],
            'partner_name'    => ['nullable', 'string'],
            'invoice_number'  => ['nullable', 'string'],

            'is_invoice_received' => ['nullable', 'boolean'],
            'is_capitalized'      => ['nullable', 'boolean'],
            'is_recurring'        => ['nullable', 'boolean'],
        ];
    }
}