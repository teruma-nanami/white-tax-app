<?php

namespace App\Http\Controllers;

use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class LedgerController extends Controller
{
	public function __construct(
		private readonly LedgerService $ledgerService
	) {}

	/**
	 * 会計年度ロック設定画面表示
	 */
	public function create()
	{
		$userId = Auth::id();

		$ledger = $this->ledgerService->getCurrentLedger($userId);

		// 念のため本人チェック（getCurrentLedger は本人前提だけど保険で）
		if ($ledger->user_id !== $userId) {
			abort(404);
		}

		return view('setting.ledger_status', [
			'ledger' => $ledger,
		]);
	}

	/**
	 * 会計年度ロック実行
	 */
	public function store(Request $request)
	{
		$userId = Auth::id();
		$ledger = $this->ledgerService->getCurrentLedger($userId);

		if ($ledger->user_id !== $userId) {
			abort(404);
		}

		try {
			$this->ledgerService->lockLedger($ledger);
		} catch (RuntimeException $e) {
			return redirect()
				->route('settings.ledger_status')
				->with('error', $e->getMessage());
		}

		return redirect()
			->route('settings.ledger_status')
			->with('success', '会計年度をロックしました。');
	}
}