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

        return view('finances.create')->with('finance', $asset->latestFinanceRecord());
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
        $finance = $request->persist();

        return redirect()->route('assets.show', ['id' => $finance->asset_id])
                         ->with('alert.success', 'Finance created!');
    }

    /**
     * Returns the form to update a finance record
     *
     * @param Finance $finance
     * @return \Illuminate\View\View
     * @throws UnauthorizedException
     */
    public function edit(Finance $finance)
    {
        if (auth()->user()->cannot('update', $finance->asset)) {
            throw new UnauthorizedException();
        }
        $finance = $this->finance->find($finance->id);

         return view('finances.edit')->with('finance', $finance);
    }

    public function update(Request $request, Finance $finance)
    {
        // TODO: Update; Pass existing data to Vue component
    }
}
