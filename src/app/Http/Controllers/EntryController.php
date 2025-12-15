<?php

namespace App\Http\Controllers;

use App\Services\EntryQueryService;
use App\Services\EntryCommandService;
use App\Http\Requests\EntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
	public function __construct(
		private readonly EntryQueryService $entryQueryService,
		private readonly EntryCommandService $entryCommandService,
	) {}

	/**
	 * 取引一覧
	 */
	public function index()
	{
		$data = $this->entryQueryService->getEntriesForCurrentYear(Auth::id());

		return view('entries.index', [
			'entries' => $data['entries'],
			'year'    => $data['year'],
			'ledger'  => $data['ledger'],
		]);
	}

	/**
	 * 取引登録画面
	 */
	public function create()
	{
		$data = $this->entryQueryService->prepareCreateData(auth()->id());

		return view('entries.create', [
			'ledger'           => $data['ledger'],
			'isInvoiceEnabled' => $data['isInvoiceEnabled'],
		]);
	}

	/**
	 * 取引登録処理
	 */
	public function store(EntryRequest $request)
	{
		$this->entryQueryService->createEntry(
			userId: auth()->id(),
			data: $request->validated()
		);

		return redirect()
			->route('entries.index')
			->with('success', '取引を登録しました');
	}

	/**
	 * 取引編集画面
	 */
	public function edit(int $entry)
	{
		$data = $this->entryQueryService->getEntryForEdit(
			entryId: $entry,
			userId: Auth::id()
		);

		return view('entries.edit', [
			'entry'            => $data['entry'],
			'ledger'           => $data['ledger'],
			'isInvoiceEnabled' => $data['isInvoiceEnabled'],
		]);
	}

	/**
	 * 取引更新
	 */
	public function update(UpdateEntryRequest $request, int $entry)
	{
		$this->entryCommandService->update(
			entryId: $entry,
			userId: Auth::id(),
			data: $request->validated()
		);

		return redirect()
			->route('entries.index')
			->with('success', '取引を更新しました');
	}

	/**
	 * カテゴリー別集計結果
	 */
	public function categories()
	{
		$data = $this->entryQueryService
			->getCategorySummaryForCurrentYear(auth()->id());

		return view('entries.category_summary', [
			'year'              => $data['year'],
			'ledger'            => $data['ledger'],
			'categorySummaries' => $data['categorySummaries'],
		]);
	}

	/**
	 * 減価償却対象一覧（候補）
	 */
	public function capitalized()
	{
		$data = $this->entryQueryService
			->getCapitalizedCandidatesForCurrentYear(auth()->id());

		return view('entries.capitalized', [
			'year'      => $data['year'],
			'threshold' => $data['threshold'],
			'entries'   => $data['entries'],
		]);
	}
}