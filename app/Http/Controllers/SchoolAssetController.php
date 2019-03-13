<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Exceptions\UnauthorizedException;
use App\School;

class SchoolAssetController extends Controller
{
	protected $school;
	protected $asset;

	/**
	 * SchoolAssetController constructor.
	 * @param School $school
	 * @param Asset $asset
	 */
	public function __construct(School $school, Asset $asset)
	{
		$this->school = $school;
		$this->asset = $asset;
	}

	/**
	 * Displays the assets for the specified school
	 *
	 * @param School $school
	 * @return \Illuminate\View\View
	 * @throws UnauthorizedException
	 */
	public function show(School $school)
	{
		if (auth()->user()->cannot('view', $school)) {
			throw new UnauthorizedException();
		}
		$school = $this->school->findOrFail($school->id);
		$assets = $school->assets;

		return view('schools.assets')->with('assets', $assets);
	}
}
