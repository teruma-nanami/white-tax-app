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
		Schema::create('user_profiles', function (Blueprint $table) {
			$table->unsignedBigInteger('user_id')->primary();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->string('app_role', 50)->default('user');

			// 税務情報
			$table->string('tax_filing_method', 50)->default('NA');

			// インボイス制度対応
			$table->boolean('invoice_enabled')->default(false);
			$table->string('invoice_number', 20)->nullable()->unique();

			// 事業情報
			$table->string('business_name')->nullable();

			// 初回ログインかどうか
			$table->boolean('first_login')->default(true);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('user_profiles');
	}
};