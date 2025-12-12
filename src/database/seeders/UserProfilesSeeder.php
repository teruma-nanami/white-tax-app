<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfiles;

class UserProfilesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        UserProfiles::updateOrCreate(
            ['user_id' => $user->id],
            [
                'app_role' => 'user',
                'tax_filing_method' => 'white',
                'invoice_enabled' => false,
                'invoice_number' => null,
                'business_name' => null,
                'first_login' => false,
            ]
        );
    }
}