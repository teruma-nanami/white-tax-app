<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ledger;
use App\Models\User;

class LedgerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $year = now()->year;

        Ledger::firstOrCreate(
            [
                'user_id' => $user->id,
                'fiscal_year' => $year,
            ],
            [
                'status' => 'Draft',
                'locked_at' => null,
            ]
        );
    }
}