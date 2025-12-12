<?php

namespace Database\Factories;

use App\Models\TaxFilingData;
use App\Models\User;
use App\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFilingDataFactory extends Factory
{
    protected $model = TaxFilingData::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ledger_id' => Ledger::factory()->draft(),

            'salary_income' => $this->faker->numberBetween(0, 8000000),
            'salary_withholding_tax' => $this->faker->numberBetween(0, 800000),
            'salary_social_insurance_paid' => $this->faker->numberBetween(0, 600000),
            'salary_life_insurance_ded' => $this->faker->numberBetween(0, 200000),
            'salary_earthquake_insurance_ded' => $this->faker->numberBetween(0, 50000),
            'salary_dependents_count' => $this->faker->numberBetween(0, 4),
            'salary_spouse_ded_applied' => $this->faker->boolean(),
            'salary_commute_allowance_non_taxable' => $this->faker->numberBetween(0, 200000),
            'salary_other_deductions' => $this->faker->numberBetween(0, 150000),

            'life_insurance_general' => $this->faker->numberBetween(0, 80000),
            'life_insurance_medical' => $this->faker->numberBetween(0, 80000),
            'life_insurance_pension' => $this->faker->numberBetween(0, 80000),

            'social_insurance_ded' => $this->faker->numberBetween(0, 800000),
            'medical_expense_ded' => $this->faker->numberBetween(0, 300000),
            'donation_ded' => $this->faker->numberBetween(0, 100000),
            'spouse_deduction_applied' => $this->faker->boolean(),
            'dependent_count' => $this->faker->numberBetween(0, 4),

            'small_enterprise_mutual_aid' => $this->faker->numberBetween(0, 300000),
            'ideco_contributions' => $this->faker->numberBetween(0, 300000),

            'home_loan_year_end_balance' => $this->faker->numberBetween(0, 50000000),
            'home_loan_deduction_amount' => $this->faker->numberBetween(0, 400000),
            'home_loan_type' => $this->faker->randomElement(['general', 'specified', 'certified']),
            'home_loan_year_number' => $this->faker->numberBetween(1, 13),

            'misc_deductions' => $this->faker->numberBetween(0, 100000),
        ];
    }
}
