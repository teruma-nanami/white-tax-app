<?php

namespace App\Http\Controllers;

use App\Services\EntryService;
use Illuminate\Http\Request;

class EntryController extends Controller
{
	private EntryService $entryService;

	public function __construct(EntryService $entryService)
	{
		$this->entryService = $entryService;
	}

	/**
	 * 取引一覧
	 */
	public function index()
	{
		$data = $this->entryService->getEntryList();

		return view('entries.index', $data);
	}
	/**
	 * 取引登録画面
	 */
	public function create()
	{
		$data = $this->entryService->getCreateData();
		return view('entries.create', $data);
	}

	/**
	 * 取引保存
	 */
	public function store(Request $request)
	{
		$this->entryService->storeEntry($request->all());

		return redirect()
			->route('entries.index')
			->with('success', '取引を登録しました');
	}
}