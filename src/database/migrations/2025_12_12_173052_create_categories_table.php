<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->id();

			// 科目名（例：売上、消耗品費）
			$table->string('category_name', 100)->unique();

			// Revenue | Expense（白色単式簿記の分類用ラベル）
			$table->string('default_type', 20);

			// 課税区分（例：StandardTax、ReducedTax、NonTaxable など）
			$table->string('default_tax_category', 50);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('categories');
	}
};