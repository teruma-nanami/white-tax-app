<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'default_type',
        'default_tax_category',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function userPreferences()
    {
        return $this->hasMany(UserPreference::class);
    }
}