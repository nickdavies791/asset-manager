<?php

namespace App\Http\Controllers;

use App\Asset;
use App\School;
use Illuminate\Http\Request;

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
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(School $school)
	{
		if (auth()->user()->cannot('view', $school)) {
			return redirect('home')->with('alert.danger', 'You do not have access to view this school\'s assets');
		}
		$school = $this->school->findOrFail($school->id);
		$assets = $school->assets;

		return view('schools.assets')->with('assets', $assets);
	}
}
