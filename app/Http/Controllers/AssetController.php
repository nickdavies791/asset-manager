<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Exceptions\UnauthorizedException;
use App\Finance;
use App\Http\Requests\StoreAsset;
use App\Http\Requests\UpdateAsset;

class AssetController extends Controller
{
	protected $asset;
	protected $finance;

	/**
	 * AssetController constructor.
	 * @param Asset $asset
	 * @param Finance $finance
	 */
	public function __construct(Asset $asset, Finance $finance)
	{
		$this->asset = $asset;
		$this->finance = $finance;
	}

	/**
	 * Returns the form to create new assets
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 * @throws UnauthorizedException
	 */
	public function create()
	{
		if (auth()->user()->cannot('create', $this->asset)) {
			throw new UnauthorizedException();
		}

		return view('assets.create');
	}

	/**
	 * Stores a new asset
	 *
	 * @param StoreAsset $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(StoreAsset $request)
	{
		$asset = $this->asset->create([
			'school_id' => $request->school_id,
			'category_id' => $request->category_id,
			'type_id' => $request->type_id,
			'name' => $request->name,
			'tag' => $request->tag,
			'serial_number' => $request->serial_number,
			'make' => $request->make,
			'model' => $request->model,
			'processor' => $request->processor,
			'memory' => $request->memory,
			'storage' => $request->storage,
			'operating_system' => $request->operating_system,
			'warranty' => $request->warranty,
			'notes' => $request->notes,
		]);

		if ($asset->exists()) {
			$this->finance->create([
				'asset_id' => $asset->id,
				'accounting_start' => $request->accounting_start,
				'accounting_end' => $request->accounting_end,
				'purchase_date' => $request->purchase_date,
				'end_of_life' => $request->end_of_life,
				'purchase_cost' => $request->purchase_cost,
				'current_value' => $request->current_value,
				'depreciation' => $request->depreciation,
				'net_book_value' => $request->net_book_value,
			]);
		}

		return redirect()->route('assets.show', ['id' => $asset->id])->with('alert.success', 'Asset created!');
	}

	/**
	 * Displays the specified asset if the user is authenticated
	 *
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 * @throws UnauthorizedException
	 */
	public function show(Asset $asset)
	{
		if (auth()->user()->cannot('view', $asset)) {
			throw new UnauthorizedException();
		}
		$asset = $this->asset->find($asset->id);

		return view('assets.show')->with('asset', $asset);
	}

	/**
	 * Displays the edit form for updating assets
	 *
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 * @throws UnauthorizedException
	 */
	public function edit(Asset $asset)
	{
		if (auth()->user()->cannot('update', $asset)) {
			throw new UnauthorizedException();
		}
		$asset = $this->asset->find($asset->id);

		return view('assets.edit')->with('asset', $asset);
	}

	/**
	 * Updates the specified asset in storage
	 *
	 * @param UpdateAsset $request
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(UpdateAsset $request, Asset $asset)
	{
		$asset->update([
			'school_id' => $request->school_id,
			'category_id' => $request->category_id,
			'type_id' => $request->type_id,
			'tag' => $request->tag,
			'name' => $request->name,
			'serial_number' => $request->serial_number,
			'make' => $request->make,
			'model' => $request->model,
			'processor' => $request->processor,
			'memory' => $request->memory,
			'storage' => $request->storage,
			'operating_system' => $request->operating_system,
			'warranty' => $request->warranty,
			'notes' => $request->notes,
		]);

		return redirect()->route('assets.show', ['id' => $asset->id])->with('alert.success', 'Asset updated!');
	}

	/**
	 * Removes the specified asset from storage
	 *
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws UnauthorizedException
	 */
	public function destroy(Asset $asset)
	{
		if (auth()->user()->cannot('delete', $asset)) {
			throw new UnauthorizedException();
		}
		$this->asset->destroy($asset->id);

		return redirect()->route('home')->with('alert.success', 'Asset deleted!');
	}
}
