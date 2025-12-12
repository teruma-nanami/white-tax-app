<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ledger_id',
        'category_id',
        'tax_rule_id',
        'transaction_date',
        'amount_inc_tax',
        'tax_category',
        'tax_amount',
        'invoice_number',
        'description',
        'partner_name',
        'is_excluded_from_expense',
        'is_recurring',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'is_excluded_from_expense' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function taxRule()
    {
        return $this->belongsTo(TaxRule::class);
    }
}