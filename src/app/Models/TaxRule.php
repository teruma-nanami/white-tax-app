<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_type',
        'value_numeric',
        'fiscal_year',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}