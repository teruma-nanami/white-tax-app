<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
	public function __construct(
		private readonly InvoiceService $invoiceService
	) {}

	/**
	 * インボイス収支一覧
	 */
	public function index()
	{
		$user = Auth::user();

		// インボイス登録済みかどうかチェック
		// userProfile リレーション前提（例：User::userProfile）
		$profile = $user->userProfile ?? null;

		if (!$profile || !$profile->invoice_enabled) {
			// 仕様：インボイス未登録ユーザーはアクセス不可
			abort(403, 'インボイス登録を行っていないため、このページにはアクセスできません。');
		}

		$data = $this->invoiceService->getInvoiceEntriesForCurrentYear($user->id);

		return view('invoice.index', [
			'ledger'  => $data['ledger'],
			'year'    => $data['year'],
			'entries' => $data['entries'],
			'summary' => $data['summary'],
		]);
	}
}