<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfiles extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    // primary key is `user_id` (not the default `id`)
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'app_role',
        'tax_filing_method',
        'invoice_enabled',
        'invoice_number',
        'business_name',
        'first_login',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}