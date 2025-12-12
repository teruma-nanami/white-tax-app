<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRule;

class TaxRuleSeeder extends Seeder
{
    public function run(): void
    {
        $year = now()->year;

        $rules = [
            ['rule_type' => 'STANDARD', 'value_numeric' => 0.10],
            ['rule_type' => 'REDUCED',  'value_numeric' => 0.08],
            ['rule_type' => 'EXEMPT',   'value_numeric' => 0.00],
        ];

        foreach ($rules as $rule) {
            TaxRule::firstOrCreate(
                [
                    'rule_type' => $rule['rule_type'],
                    'fiscal_year' => $year,
                ],
                [
                    'value_numeric' => $rule['value_numeric'],
                ]
            );
        }
    }
}