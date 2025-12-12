<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            TaxRuleSeeder::class,
            UserSeeder::class,
            UserProfilesSeeder::class,
            LedgerSeeder::class,
            EntrySeeder::class,
            TaxFilingDataSeeder::class,
        ]);
    }
}