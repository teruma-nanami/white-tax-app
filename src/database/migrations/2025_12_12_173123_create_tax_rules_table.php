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
		Schema::create('tax_rules', function (Blueprint $table) {
			$table->id();

			// 税区分 (StandardTax / ReducedTax / NonTaxable)
			$table->string('rule_type', 50);

			// 税率値 (例: 0.10 ＝ 10%)
			$table->decimal('value_numeric', 15, 4);

			// 税制変更に対応するため年度を持つ
			$table->unsignedSmallInteger('fiscal_year');

			// 同じ年度に同じタイプの税率は一つだけ
			$table->unique(['rule_type', 'fiscal_year']);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tax_rules');
	}
};