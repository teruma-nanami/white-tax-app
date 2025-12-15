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
        'description',
        'partner_name',
        'is_invoice_received',
        'is_capitalized',
        'is_recurring',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'is_invoice_received' => 'boolean',
        'is_capitalized' => 'boolean',
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