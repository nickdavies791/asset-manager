<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Events\AssetCreated;
use App\Exceptions\UnauthorizedException;
use App\Finance;
use App\Http\Requests\StoreAsset;
use App\Http\Requests\UpdateAsset;

class AssetController extends Controller
{
    /**
     * The Asset model instance.
     *
     * @var Asset $asset
     */
    protected $asset;

    /**
     * The Finance model instance.
     *
     * @var Finance $finance
     */
    protected $finance;

    /**
     * AssetController constructor.
     *
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
        $asset = $request->persist();
        event(new AssetCreated(auth()->user(), $asset));

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
        $asset = $this->asset->with(['finances'])->find($asset->id);

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
        $asset = $request->persist($asset);

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
