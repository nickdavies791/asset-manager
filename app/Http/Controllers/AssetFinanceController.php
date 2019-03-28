<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Exceptions\UnauthorizedException;
use App\Finance;
use App\Http\Requests\StoreFinance;
use Illuminate\Http\Request;

class AssetFinanceController extends Controller
{
    protected $asset;
    protected $finance;

	/**
	 * AssetFinanceController constructor.
	 * @param Asset $asset
	 * @param Finance $finance
	 */
	public function __construct(Asset $asset, Finance $finance)
	{
		$this->asset = $asset;
		$this->finance = $finance;
	}

	/**
	 * Returns the form to create new finance records
	 *
	 * @param Asset $asset
	 * @return \Illuminate\View\View
	 * @throws UnauthorizedException
	 */
	public function create(Asset $asset)
	{
		if (auth()->user()->cannot('update', $asset)) {
			throw new UnauthorizedException();
		}

		return view('finances.create');
	}

	/**
	 * Stores a new finance record
	 *
	 * @param StoreFinance $request
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(StoreFinance $request, Asset $asset)
	{
		$finance = $request->persist($asset);

		return redirect()->route('assets.show', ['id' => $finance->asset_id])->with('alert.success', 'Finance created!');
	}
}
