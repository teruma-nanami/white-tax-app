<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            /*
            |--------------------------------------------------------------------------
            | 収入（収支内訳書）
            |--------------------------------------------------------------------------
            */
            ['category_name' => '売上（事業収入）', 'default_type' => 'Revenue', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '雑収入',           'default_type' => 'Revenue', 'default_tax_category' => 'NonTaxable'],

            /*
            |--------------------------------------------------------------------------
            | 経費（国税庁：収支内訳書 一般）
            |--------------------------------------------------------------------------
            */
            ['category_name' => '仕入高',       'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '外注工賃',     'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '減価償却費',   'default_type' => 'Expense', 'default_tax_category' => 'NonTaxable'],
            ['category_name' => '地代家賃',     'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '水道光熱費',   'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '旅費交通費',   'default_type' => 'Expense', 'default_tax_category' => 'NonTaxable'],
            ['category_name' => '通信費',       'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '広告宣伝費',   'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '接待交際費',   'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '損害保険料',   'default_type' => 'Expense', 'default_tax_category' => 'NonTaxable'],
            ['category_name' => '修繕費',       'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '消耗品費',     'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '福利厚生費',   'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
            ['category_name' => '給料賃金',     'default_type' => 'Expense', 'default_tax_category' => 'NonTaxable'],
            ['category_name' => '租税公課',     'default_type' => 'Expense', 'default_tax_category' => 'NonTaxable'],
            ['category_name' => '図書費',       'default_type' => 'Expense', 'default_tax_category' => 'ReducedTax'],
            ['category_name' => '雑費',         'default_type' => 'Expense', 'default_tax_category' => 'StandardTax'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['category_name' => $category['category_name']],
                $category
            );
        }
    }
}