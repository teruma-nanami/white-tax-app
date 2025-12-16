<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Services\FilingService;
use App\Http\Requests\DeductionRequest;

class FilingController extends Controller
{
	public function __construct(
		private readonly FilingService $filingService
	) {}

	/**
	 * 確定申告一覧
	 */
	public function index()
	{
		$userId = auth()->id();

		$ledgers = $this->filingService->getLedgersForUser($userId);

		return view('filing.index', [
			'ledgers' => $ledgers,
		]);
	}

	/**
	 * 指定年度の年間サマリー
	 */
	public function show(Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$data = $this->filingService->getAnnualSummary($ledger);

		return view('filing.entries_summary', [
			'year'    => $data['year'],
			'summary' => $data['summary'],
			'entries' => $data['entries'],
			'ledger'  => $ledger,
		]);
	}

	/**
	 * 控除入力画面表示
	 * GET /filings/{ledger}/deductions
	 */
	public function create(Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$taxFilingData = $this->filingService->prepareDeductionForm($ledger);

		return view('filing.deductions', [
			'ledger'        => $ledger,
			'taxFilingData' => $taxFilingData,
		]);
	}

	/**
	 * 控除データ保存
	 * POST /filings/{ledger}/deductions
	 */
	public function store(DeductionRequest $request, Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$this->filingService->storeDeductionData(
			ledger: $ledger,
			userId: auth()->id(),
			data: $request->validated()
		);

		return redirect()
			->route('filings.entries_summary', ['ledger' => $ledger->id])
			->with('success', '控除情報を保存しました。');
	}

	/**
	 * 控除編集フォーム表示
	 */
	public function edit(Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$taxFilingData = $this->filingService->getDeductionDataForEdit($ledger);

		return view('filing.deductions_edit', [
			'ledger'        => $ledger,
			'taxFilingData' => $taxFilingData,
		]);
	}

	/**
	 * 控除編集内容の更新
	 */
	public function update(DeductionRequest $request, Ledger $ledger)
	{
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$this->filingService->updateDeductionData(
			ledger: $ledger,
			userId: auth()->id(),
			data: $request->validated()
		);

		return redirect()
			->route('filings.entries_summary', ['ledger' => $ledger->id])
			->with('success', '控除情報を更新しました。');
	}
	/**
	 * 確定申告書プレビュー（確定申告書B + 収支決算書）
	 */
	public function preview(Ledger $ledger)
	{
		// 自分の帳簿以外は見えないようにする
		if ($ledger->user_id !== auth()->id()) {
			abort(404);
		}

		$data = $this->filingService->buildTaxReturnPreview($ledger);

		return view('filing.preview', [
			'ledger'          => $ledger,
			'year'            => $data['year'],
			'incomeStatement' => $data['incomeStatement'],
			'taxReturn'       => $data['taxReturn'],
		]);
	}
}