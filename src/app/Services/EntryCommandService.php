<?php

namespace App\Services;

use App\Models\Entry;
use Illuminate\Support\Facades\DB;

class EntryCommandService
{
  /**
   * 取引更新
   */
  public function update(int $entryId, int $userId, array $data): void
  {
    $entry = Entry::where('id', $entryId)
      ->where('user_id', $userId)
      ->firstOrFail();

    DB::transaction(function () use ($entry, $data) {
      $entry->update([
        'transaction_date' => $data['transaction_date'],
        'amount_inc_tax'   => $data['amount_inc_tax'],
        'description'      => $data['description'] ?? null,
        'partner_name'     => $data['partner_name'] ?? null,
        'is_invoice_received' => $data['is_invoice_received'] ?? $entry->is_invoice_received,
        'is_capitalized'      => $data['is_capitalized'] ?? $entry->is_capitalized,
        'is_recurring'        => $data['is_recurring'] ?? $entry->is_recurring,

        // preserve tax_category if not provided (migration requires not-null)
        'tax_category' => $data['tax_category'] ?? $entry->tax_category,
      ]);
    });
  }
}