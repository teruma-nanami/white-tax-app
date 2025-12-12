<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition(): array
    {
        return [
            // Seeder 側で上書き
            'user_id' => null,
            'ledger_id' => null,
            'category_id' => null,
            'tax_rule_id' => null,

            'transaction_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'amount_inc_tax' => $this->faker->numberBetween(1_000, 200_000),

            // あなたの設計どおり「文字列」
            'tax_category' => 'StandardTax',

            'description' => 'テスト取引',
            'partner_name' => 'テスト取引先',

            // DBに存在するものだけ
            'is_recurring' => false,
        ];
    }

    public function recurring(): static
    {
        return $this->state(fn() => [
            'is_recurring' => true,
        ]);
    }
}