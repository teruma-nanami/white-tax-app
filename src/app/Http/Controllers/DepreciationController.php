<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Services\DepreciationService;
use App\Http\Requests\DepreciationRequest;

class DepreciationController extends Controller
{
	public function __construct(
		private readonly DepreciationService $depreciationService
	) {}

	/**
	 * 減価償却費一覧
	 * 110,001円以上の高額経費候補を表示（備忘録用途）
	 */
	public function index(Ledger $ledger)
	{
		// 自分以外のユーザーの Ledger は見せない
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$threshold = 110001;

		$entries = $this->depreciationService->getDepreciationCandidates(
			ledger: $ledger,
			threshold: $threshold
		);

		return view('depreciation.index', [
			'ledger'    => $ledger,
			'year'      => $ledger->fiscal_year,
			'threshold' => $threshold,
			'entries'   => $entries,
		]);
	}

	/**
	 * 減価償却費登録画面表示
	 */
	public function create(Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$data = $this->depreciationService->prepareCreate($ledger);

		// $data には ['ledger', 'year', 'categories'] が入っている想定
		return view('depreciation.wizard', $data);
	}

	/**
	 * 減価償却費登録処理
	 */
	public function store(DepreciationRequest $request, Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$this->depreciationService->storeDepreciationEntry(
			ledger: $ledger,
			userId: auth()->id(),
			data: $request->validated()
		);

		return redirect()
			->route('filings.depreciation.index', ['ledger' => $ledger->id])
			->with('success', '減価償却費を登録しました。');
	}
}