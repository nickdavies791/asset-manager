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

	public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
