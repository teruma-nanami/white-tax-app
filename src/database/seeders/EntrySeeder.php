<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entry;
use App\Models\User;
use App\Models\Ledger;
use App\Models\Category;
use App\Models\TaxRule;

class EntrySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $ledger = Ledger::first();
        $categories = Category::all();
        $taxRules = TaxRule::all();

        // 通常取引
        Entry::factory()
            ->count(20)
            ->create([
                'user_id' => $user->id,
                'ledger_id' => $ledger->id,
                'category_id' => $categories->random()->id,
                'tax_rule_id' => $taxRules->random()->id,
            ]);

        // 定期課金
        Entry::factory()
            ->recurring()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'ledger_id' => $ledger->id,
                'category_id' => $categories->random()->id,
                'tax_rule_id' => $taxRules->random()->id,
            ]);
    }
}