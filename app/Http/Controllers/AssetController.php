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

    public function edit(Asset $asset)
    {
        //
    }

    public function update(Request $request, Asset $asset)
    {
		//
    }

    public function destroy(Asset $asset)
    {
        //
    }
}
