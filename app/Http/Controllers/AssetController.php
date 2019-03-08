<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
	protected $asset;

	/**
	 * AssetController constructor.
	 * @param Asset $asset
	 */
	public function __construct(Asset $asset)
	{
		$this->asset = $asset;
	}

	/**
	 * Returns the form to create new assets
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function create()
	{
		if (auth()->user()->cannot('create', $this->asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to create assets');
		}

		return view('assets.create');
	}

	/**
	 * Stores a new asset
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		if (auth()->user()->cannot('create', $this->asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to create assets');
		}
		$asset = $this->asset->create([
			'school_id' => $request->school,
			'name' => $request->name,
			'tag' => $request->tag
		]);

		return redirect()->route('assets.show', ['id' => $asset->id])->with('alert.success', 'Asset created!');
	}

	/**
	 * Displays the specified asset if the user is authenticated
	 *
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function show(Asset $asset)
	{
		if (auth()->user()->cannot('view', $asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to this asset');
		}
		$asset = $this->asset->find($asset->id);

		return view('assets.show')->with('asset', $asset);
	}

	/**
	 * Displays the edit form for updating assets
	 *
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit(Asset $asset)
	{
		if (auth()->user()->cannot('update', $asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to update this asset');
		}
		$asset = $this->asset->find($asset->id);

		return view('assets.edit')->with('asset', $asset);
	}

	/**
	 * Updates the specified asset in storage
	 *
	 * @param Request $request
	 * @param Asset $asset
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, Asset $asset)
	{
		if (auth()->user()->cannot('update', $asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to update assets');
		}
		$asset->update([
			'school_id' => $request->school,
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
	 */
	public function destroy(Asset $asset)
	{
		if (auth()->user()->cannot('delete', $asset)) {
			return redirect('home')->with('alert.danger', 'You do not have access to delete assets');
		}
		$this->asset->destroy($asset->id);

		return redirect()->route('home')->with('alert.success', 'Asset deleted!');
	}
}
