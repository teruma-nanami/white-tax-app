<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxFilingData;
use App\Models\User;
use App\Models\Ledger;

class TaxFilingDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $ledger = Ledger::first();

        TaxFilingData::firstOrCreate(
            [
                'user_id' => $user->id,
                'ledger_id' => $ledger->id,
            ],
            [
                'salary_income' => 4500000,
                'salary_withholding_tax' => 320000,
                'social_insurance_ded' => 650000,
                'medical_expense_ded' => 120000,
                'donation_ded' => 80000,
                'dependent_count' => 1,
            ]
        );
    }
}