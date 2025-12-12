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
		Schema::create('user_preferences', function (Blueprint $table) {
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('category_id');

			// 複合主キー
			$table->primary(['user_id', 'category_id']);

			// 外部キー制約
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

			// 設定データ
			$table->boolean('is_hidden')->default(false);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('user_preferences');
	}
};